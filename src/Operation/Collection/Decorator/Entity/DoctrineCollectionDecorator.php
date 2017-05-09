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

namespace Vain\Doctrine\Operation\Collection\Decorator\Entity;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;
use Vain\Doctrine\Entity\DoctrineEntityManager;
use Vain\Core\Operation\Collection\OperationCollectionInterface;
use Vain\Core\Operation\Collection\Decorator\AbstractOperationCollectionDecorator;
use Vain\Core\Result\ResultInterface;
use Vain\Doctrine\Operation\Collection\Result\DoctrineCollectionFailedResult;

/**
 * Class DoctrineCollectionDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCollectionDecorator extends AbstractOperationCollectionDecorator
{
    private $entityManager;

    /**
     * DoctrineCollectionDecorator constructor.
     *
     * @param OperationCollectionInterface $collection
     * @param DoctrineEntityManager        $entityManager
     */
    public function __construct(OperationCollectionInterface $collection, DoctrineEntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($collection);
    }

    /**
     * @inheritDoc
     */
    public function execute() : ResultInterface
    {
        try {
            $this->entityManager->init();

            $result = parent::execute();
            if (false === $result->getStatus()) {
                return $result;
            }

            $this->entityManager->flush();
        } catch (DBALException $exception) {
            return new DoctrineCollectionFailedResult($exception);
        } catch (ORMException $exception) {
            return new DoctrineCollectionFailedResult($exception);
        }

        return $result;
    }
}
