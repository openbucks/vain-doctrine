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
    private $entity;

    private $entityManager;

    /**
     * DoctrineCreateEntityOperation constructor.
     *
     * @param EntityInterface          $entity
     * @param EntityManagerInterface   $entityManager
     * @param EventResolverInterface   $eventResolver
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityInterface $entity,
        EntityManagerInterface $entityManager,
        EventResolverInterface $eventResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        parent::__construct($eventResolver, $eventDispatcher);
    }

    /**
     * @inheritDoc
     */
    public function createEntity() : EntityInterface
    {
        $this->entityManager->persist($this->entity);

        return $this->entity;
    }
}
