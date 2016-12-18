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
use Vain\Core\Entity\Operation\AbstractDeleteEntityOperation;
use Vain\Core\Event\Dispatcher\EventDispatcherInterface;
use Vain\Core\Event\Resolver\EventResolverInterface;

/**
 * Class DoctrineDeleteEntityOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineDeleteEntityOperation extends AbstractDeleteEntityOperation
{
    private $entity;

    private $entityManager;

    /**
     * DoctrineDeleteEntityOperation constructor.
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
        $this->entity = $entity;
        $this->entityManager = $entityManager;
        parent::__construct($eventResolver, $eventDispatcher);
    }

    /**
     * @inheritDoc
     */
    public function deleteEntity() : EntityInterface
    {
        $this->entityManager->remove($this->entity);

        return $this->entity;
    }
}
