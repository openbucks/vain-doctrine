<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   vain-doctrine
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/vain-doctrine
 */
declare(strict_types=1);

namespace Vain\Doctrine\Entity\Factory;

use Doctrine\ORM\Mapping\ClassMetadataInfo as ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;
use Vain\Core\Entity\EntityInterface;
use Vain\Core\Entity\Factory\EntityFactoryInterface;

/**
 * Class DoctrineEntityFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEntityFactory implements EntityFactoryInterface
{
    private $entityManager;

    /**
     * DoctrineEntityFactory constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $entityName
     *
     * @return ClassMetadata
     */
    public function getClassMetadata(string $entityName): ClassMetadata
    {
        return $this->entityManager->getClassMetadata($entityName);
    }

    public function getEntityName(ClassMetadata $classMetadata, array $entityData): string
    {
        if (ClassMetadata::INHERITANCE_TYPE_NONE === $classMetadata->inheritanceType) {
            return $classMetadata->name;
        }
        if (false === array_key_exists($classMetadata->discriminatorColumn['name'], $entityData)) {
            throw new MissingDiscriminatorColumnException(
                $this,
                $classMetadata->discriminatorColumn['name'],
                $entityData
            );
        }
        $discriminatorColumnValue = $entityData[$classMetadata->discriminatorColumn['name']];
        if (false === array_key_exists($discriminatorColumnValue, $classMetadata->discriminatorMap)) {
            throw new UnknownDiscriminatorValueException(
                $this,
                $discriminatorColumnValue,
                $classMetadata->discriminatorMap
            );
        }

        return $classMetadata->discriminatorMap[$discriminatorColumnValue];
    }

    /**
     * @param EntityInterface $entity
     * @param ClassMetadata   $classMetadata
     * @param array           $entityData
     *
     * @return EntityInterface
     */
    public function populate(
        EntityInterface $entity,
        ClassMetadata $classMetadata,
        array $entityData
    ): EntityInterface {
        $parsedData = [];
        foreach ($entityData as $column => $value) {
            if (array_key_exists($column, $classMetadata->fieldNames)) {
                $parsedData[$classMetadata->fieldNames[$column]] = $value;
                continue;
            }
            foreach ($classMetadata->associationMappings as $associationMapping) {
                if (false === $associationMapping['type'] <= 2) {
                    continue;
                }
                if ($column !== $associationMapping['joinColumns'][0]['name']) {
                    continue;
                }
                if (null === ($associatedEntity = $this->entityManager->find(
                        $associationMapping['targetEntity'],
                        $value
                    ))
                ) {
                    continue;
                }
                $parsedData[$associationMapping['fieldName']] = $associatedEntity;
            }
        }

        return $entity->fromArray($parsedData);
    }

    /**
     * @inheritDoc
     */
    public function createEntity(string $entityName, array $entityData): EntityInterface
    {
        $classMetadata = $this->getClassMetadata(
            $this->getEntityName($this->getClassMetadata($entityName), $entityData)
        );
        /**
         * @var EntityInterface $entity
         */
        $entity = $classMetadata->getReflectionClass()->newInstance();

        return $this->populate($entity, $classMetadata, $entityData);
    }

    /**
     * @inheritDoc
     */
    public function updateEntity(EntityInterface $entity, array $entityData): EntityInterface
    {
        $classMetadata = $this->getClassMetadata(get_class($entity));

        return $this->populate($entity, $classMetadata, $entityData);
    }
}
