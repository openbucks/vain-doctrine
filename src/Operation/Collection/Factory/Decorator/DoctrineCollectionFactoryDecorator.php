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

namespace Vain\Doctrine\Operation\Collection\Factory\Decorator;

use Doctrine\ORM\EntityManagerInterface;
use Vain\Doctrine\Operation\Collection\Decorator\DoctrineCollectionDecorator;
use Vain\Core\Operation\Collection\OperationCollectionInterface;
use Vain\Core\Operation\Collection\Factory\OperationCollectionFactoryInterface;
use Vain\Core\Operation\Collection\Factory\Decorator\AbstractOperationCollectionFactoryDecorator;

/**
 * Class DoctrineCollectionFactoryDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCollectionFactoryDecorator extends AbstractOperationCollectionFactoryDecorator
{
    private $entityManager;

    /**
     * DoctrineCollectionFactoryDecorator constructor.
     *
     * @param OperationCollectionFactoryInterface $collectionFactory
     * @param EntityManagerInterface     $entityManager
     */
    public function __construct(OperationCollectionFactoryInterface $collectionFactory, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($collectionFactory);
    }

    /**
     * @inheritDoc
     */
    public function create(array $operations = []) : OperationCollectionInterface
    {
        $collection = parent::create($operations);

        return new DoctrineCollectionDecorator($collection, $this->entityManager);
    }
}
