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
use Vain\Entity\EntityInterface;
use Vain\Entity\Operation\AbstractUpdateEntityOperation;
use Vain\Operation\Result\OperationResultInterface;
use Vain\Operation\Result\Successful\SuccessfulOperationResult;

/**
 * Class DoctrineUpdateEntityOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineUpdateEntityOperation extends AbstractUpdateEntityOperation
{
    private $entityManager;

    /**
     * DoctrineUpdateEntityOperation constructor.
     *
     * @param EntityInterface        $entity
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityInterface $entity, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($entity);
    }

    /**
     * @inheritDoc
     */
    public function execute() : OperationResultInterface
    {
        $this->entityManager->persist($this->getEntity());

        return new SuccessfulOperationResult();
    }
}