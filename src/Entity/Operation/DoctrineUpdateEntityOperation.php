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
    private $newEntity;

    private $oldEntity;

    private $entityManager;

    /**
     * DoctrineUpdateEntityOperation constructor.
     *
     * @param EntityInterface          $newEntity
     * @param EntityInterface          $oldEntity
     * @param EntityManagerInterface   $entityManager
     * @param EventResolverInterface   $eventResolver
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityInterface $newEntity,
        EntityInterface $oldEntity,
        EntityManagerInterface $entityManager,
        EventResolverInterface $eventResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->newEntity = $newEntity;
        $this->oldEntity = $oldEntity;
        parent::__construct($eventResolver, $eventDispatcher);
    }

    /**
     * @inheritDoc
     */
    public function getNewEntity() : EntityInterface
    {
        return $this->newEntity;
    }

    /**
     * @inheritDoc
     */
    public function getOldEntity() : EntityInterface
    {
        return $this->oldEntity;
    }

    /**
     * @inheritDoc
     */
    public function updateEntity(EntityInterface $newEntity, EntityInterface $oldEntity) : EntityInterface
    {
        $this->entityManager->persist($newEntity);

        return $newEntity;
    }
}
