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
use Vain\Doctrine\Entity\Operation\DoctrineCreateEntityOperation;
use Vain\Doctrine\Entity\Operation\DoctrineDeleteEntityOperation;
use Vain\Doctrine\Entity\Operation\DoctrineUpdateEntityOperation;
use Vain\Entity\EntityInterface;
use Vain\Entity\Operation\Factory\AbstractEntityOperationFactory;
use Vain\Entity\Operation\Factory\EntityOperationFactoryInterface;
use Vain\Operation\Factory\OperationFactoryInterface;
use Vain\Operation\OperationInterface;

/**
 * Class DoctrineEntityOperationFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEntityOperationFactory extends AbstractEntityOperationFactory implements EntityOperationFactoryInterface
{

    private $entityManager;

    /**
     * DoctrineEntityOperationFactory constructor.
     *
     * @param OperationFactoryInterface $operationFactory
     * @param EntityManagerInterface    $entityManager
     */
    public function __construct(OperationFactoryInterface $operationFactory, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($operationFactory);
    }

    /**
     * @inheritDoc
     */
    public function createEntity(EntityInterface $entity) : OperationInterface
    {
        return $this->decorate(new DoctrineCreateEntityOperation($entity, $this->entityManager));
    }

    /**
     * @inheritDoc
     */
    public function doUpdateEntity(EntityInterface $newEntity, EntityInterface $oldEntity) : OperationInterface
    {
        return $this->decorate(new DoctrineUpdateEntityOperation($newEntity, $oldEntity, $this->entityManager));
    }

    /**
     * @inheritDoc
     */
    public function deleteEntity(EntityInterface $entity) : OperationInterface
    {
        return $this->decorate(new DoctrineDeleteEntityOperation($entity, $this->entityManager));
    }
}
