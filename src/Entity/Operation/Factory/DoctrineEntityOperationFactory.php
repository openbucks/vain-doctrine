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

namespace Vain\Doctrine\Entity\Operation\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Vain\Core\Event\Dispatcher\EventDispatcherInterface;
use Vain\Core\Event\Resolver\EventResolverInterface;
use Vain\Doctrine\Entity\Operation\DoctrineCreateEntityOperation;
use Vain\Doctrine\Entity\Operation\DoctrineDeleteEntityOperation;
use Vain\Doctrine\Entity\Operation\DoctrineUpdateEntityOperation;
use Vain\Core\Entity\Operation\Factory\AbstractEntityOperationFactory;
use Vain\Core\Entity\Operation\Factory\EntityOperationFactoryInterface;
use Vain\Core\Operation\Factory\OperationFactoryInterface;
use Vain\Core\Operation\OperationInterface;

/**
 * Class DoctrineEntityOperationFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEntityOperationFactory extends AbstractEntityOperationFactory implements EntityOperationFactoryInterface
{

    private $entityManager;

    private $eventResolver;

    private $eventDispatcher;

    /**
     * DoctrineEntityOperationFactory constructor.
     *
     * @param OperationFactoryInterface $operationFactory
     * @param EntityManagerInterface    $entityManager
     * @param EventResolverInterface    $eventResolver
     * @param EventDispatcherInterface  $eventDispatcher
     */
    public function __construct(
        OperationFactoryInterface $operationFactory,
        EntityManagerInterface $entityManager,
        EventResolverInterface $eventResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->eventResolver = $eventResolver;
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($operationFactory);
    }

    /**
     * @inheritDoc
     */
    public function createOperation(string $entityName, array $entityData) : OperationInterface
    {
        return new DoctrineCreateEntityOperation(
            $this->entityManager,
            $this->entityManager->getClassMetadata($entityName),
            $entityData,
            $this->eventResolver,
            $this->eventDispatcher
        );
    }

    /**
     * @inheritDoc
     */
    public function updateOperation(
        string $entityName,
        array $criteria,
        array $entityData,
        bool $lock = false
    ) : OperationInterface
    {
        return new DoctrineUpdateEntityOperation(
            $this->entityManager,
            $this->entityManager->getClassMetadata($entityName),
            $entityName,
            $criteria,
            $entityData,
            $lock,
            $this->eventResolver,
            $this->eventDispatcher
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteOperation(string $entityName, array $criteria) : OperationInterface
    {
        return new DoctrineDeleteEntityOperation(
            $this->entityManager,
            $entityName,
            $criteria,
            $this->eventResolver,
            $this->eventDispatcher
        );
    }
}
