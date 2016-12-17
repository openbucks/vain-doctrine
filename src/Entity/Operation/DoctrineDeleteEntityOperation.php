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
    private $entityManager;

    private $entityName;

    private $criteria;

    /**
     * DoctrineDeleteEntityOperation constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param string                   $entityName
     * @param array                    $criteria
     * @param EventResolverInterface   $eventResolver
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $entityName,
        array $criteria,
        EventResolverInterface $eventResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
        $this->criteria = $criteria;
        parent::__construct($eventResolver, $eventDispatcher);
    }

    /**
     * @inheritDoc
     */
    public function deleteEntity() : EntityInterface
    {
        if (null === ($entity = $this->entityManager->getRepository($this->entityName)->findOneBy($this->criteria))) {
            return null;
        }
        $this->entityManager->remove($entity);

        return $entity;
    }
}
