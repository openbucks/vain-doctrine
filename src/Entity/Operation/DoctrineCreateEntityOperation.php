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
use Vain\Core\Result\ResultInterface;
use Vain\Core\Result\SuccessfulResult;

/**
 * Class DoctrineCreateEntityOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCreateEntityOperation extends AbstractCreateEntityOperation
{
    private $entityManager;

    /**
     * DoctrineCreateEntityOperation constructor.
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
    public function execute() : ResultInterface
    {
        $this->entityManager->persist($this->getEntity());

        return new SuccessfulResult();
    }
}
