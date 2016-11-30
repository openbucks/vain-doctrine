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

namespace Vain\Doctrine\Operation\Collection\Decorator;

use Doctrine\DBAL\DBALException;
use Vain\Doctrine\Entity\DoctrineEntityManager;
use Vain\Operation\Collection\CollectionInterface;
use Vain\Operation\Collection\Decorator\AbstractCollectionDecorator;
use Vain\Operation\Result\Failed\FailedOperationResult;
use Vain\Operation\Result\OperationResultInterface;

/**
 * Class DoctrineCollectionDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCollectionDecorator extends AbstractCollectionDecorator
{
    private $entityManager;

    /**
     * DoctrineCollectionDecorator constructor.
     *
     * @param CollectionInterface   $collection
     * @param DoctrineEntityManager $entityManager
     */
    public function __construct(CollectionInterface $collection, DoctrineEntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($collection);
    }

    /**
     * @inheritDoc
     */
    public function execute() : OperationResultInterface
    {
        try {
            $this->entityManager->init();
            $result = $this->getCollection()->execute();
            if (false === $result->getStatus()) {
                $this->entityManager->clear();

                return $result;
            }
            $this->entityManager->flush();
        } catch (DBALException $exception) {
            $this->entityManager->clear();

            return new FailedOperationResult();
        }

        return $result;
    }
}