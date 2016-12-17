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

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Vain\Core\Entity\EntityInterface;
use Vain\Core\Entity\Operation\AbstractUpdateEntityOperation;
use Vain\Core\Event\Dispatcher\EventDispatcherInterface;
use Vain\Core\Event\Resolver\EventResolverInterface;

/**
 * Class DoctrineUpdateEntityOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineUpdateEntityOperation extends AbstractUpdateEntityOperation
{
    private $entityManager;

    private $classMetadata;

    private $entityName;

    private $criteria;

    private $entityData;

    private $lock;

    /**
     * DoctrineDeleteEntityOperation constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param ClassMetadataInfo        $classMetadata
     * @param string                   $entityName
     * @param array                    $criteria
     * @param array                    $entityData
     * @param bool                     $lock
     * @param EventResolverInterface   $eventResolver
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClassMetadataInfo $classMetadata,
        string $entityName,
        array $criteria,
        array $entityData,
        bool $lock,
        EventResolverInterface $eventResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->classMetadata = $classMetadata;
        $this->entityName = $entityName;
        $this->criteria = $criteria;
        $this->entityData = $entityData;
        $this->lock = $lock;
        parent::__construct($eventResolver, $eventDispatcher);
    }

    /**
     * @inheritDoc
     */
    public function findEntity() : EntityInterface
    {
        $entity = $this->entityManager->getRepository($this->entityName)->findOneBy($this->criteria);
        if ($this->lock) {
            $this->entityManager->lock($entity, LockMode::PESSIMISTIC_WRITE);
        }

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function updateEntity(EntityInterface $entity) : EntityInterface
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

        return $entity;
    }
}
