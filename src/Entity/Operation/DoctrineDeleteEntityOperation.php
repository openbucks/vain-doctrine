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
use Vain\Entity\Operation\Delete\AbstractDeleteEntityOperation;
use Vain\Operation\Result\OperationResultInterface;
use Vain\Operation\Result\Successful\SuccessfulOperationResult;

/**
 * Class DoctrineDeleteEntityOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineDeleteEntityOperation extends AbstractDeleteEntityOperation
{
    private $entityManager;

    /**
     * DoctrineDeleteEntityOperation constructor.
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
        $this->entityManager->remove($this->getEntity());

        return new SuccessfulOperationResult();
    }
}