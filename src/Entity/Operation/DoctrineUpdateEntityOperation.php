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
use Vain\Core\Result\ResultInterface;
use Vain\Core\Result\SuccessfulResult;

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
     * @param EntityInterface        $newEntity
     * @param EntityInterface        $oldEntity
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityInterface $newEntity,
        EntityInterface $oldEntity,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        parent::__construct($newEntity, $oldEntity);
    }

    /**
     * @inheritDoc
     */
    public function execute() : ResultInterface
    {
        return new SuccessfulResult();
    }
}
