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

use Vain\Doctrine\Entity\DoctrineEntityManager;
use Vain\Operation\Collection\CollectionInterface;
use Vain\Operation\Collection\Decorator\AbstractCollectionDecorator;
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
        $this->entityManager->init();

        $result = parent::execute();
        if (false === $result->getStatus()) {
            return $result;
        }

        $this->entityManager->flush();

        return $result;
    }
}
