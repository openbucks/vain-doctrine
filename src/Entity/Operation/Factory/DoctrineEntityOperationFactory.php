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
use Vain\Doctrine\Entity\Operation\Create\DoctrineCreateEntityOperation;
use Vain\Doctrine\Entity\Operation\Delete\DoctrineDeleteEntityOperation;
use Vain\Doctrine\Entity\Operation\Update\DoctrineUpdateEntityOperation;
use Vain\Entity\EntityInterface;
use Vain\Entity\Operation\Factory\EntityOperationFactoryInterface;
use Vain\Operation\OperationInterface;

/**
 * Class DoctrineEntityOperationFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEntityOperationFactory implements EntityOperationFactoryInterface
{

    private $entityManager;

    /**
     * DoctrineEntityOperationFactory constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function create(EntityInterface $entity) : OperationInterface
    {
        return new DoctrineCreateEntityOperation($entity, $this->entityManager);
    }

    /**
     * @inheritDoc
     */
    public function update(EntityInterface $entity) : OperationInterface
    {
        return new DoctrineUpdateEntityOperation($entity, $this->entityManager);
    }

    /**
     * @inheritDoc
     */
    public function delete(EntityInterface $entity) : OperationInterface
    {
        return new DoctrineDeleteEntityOperation($entity, $this->entityManager);
    }
}