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
declare(strict_types = 1);

namespace Vain\Doctrine\Entity\Operation;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Vain\Core\Entity\EntityInterface;
use Vain\Core\Entity\Operation\AbstractCreateEntityOperation;
use Vain\Core\Event\Dispatcher\EventDispatcherInterface;
use Vain\Core\Event\Resolver\EventResolverInterface;

/**
 * Class DoctrineCreateEntityOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCreateEntityOperation extends AbstractCreateEntityOperation
{
    private $entityManager;

    private $classMetadata;

    private $entityData;

    /**
     * DoctrineCreateEntityOperation constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param ClassMetadataInfo        $classMetadata
     * @param array                    $entityData
     * @param EventResolverInterface   $eventResolver
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClassMetadataInfo $classMetadata,
        array $entityData,
        EventResolverInterface $eventResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->classMetadata = $classMetadata;
        $this->entityData = $entityData;
        parent::__construct($eventResolver, $eventDispatcher);
    }

    /**
     * @inheritDoc
     */
    public function createEntity() : EntityInterface
    {
        /**
         * @var EntityInterface $entity
         */
        $entity = $this->classMetadata->getReflectionClass()->newInstance();
        $parsedData = [];
        foreach ($this->entityData as $column => $value) {
            if (array_key_exists($column, $this->classMetadata->fieldNames)) {
                $parsedData[$this->classMetadata->fieldNames[$column]] = $value;
                continue;
            }
            foreach ($this->classMetadata->associationMappings as $associationMapping) {
                if (false === $associationMapping['type'] <= 2) {
                    continue;
                }
                if ($column !== $associationMapping['joinColumn']['name']) {
                    continue;
                }
                if (null === ($entity = $this->entityManager->find($associationMapping['targetEntity'], $value))) {
                    return null;
                }
                $parsedData[$associationMapping['fieldName']] = $entity;
            }
        }

        $this->entityManager->persist($entity->fromArray($parsedData));

        return $entity;
    }
}
