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
use Vain\Operation\Collection\CollectionInterface;
use Vain\Operation\Collection\Factory\CollectionFactoryInterface;
use Vain\Operation\Collection\Factory\Decorator\AbstractCollectionFactoryDecorator;

/**
 * Class DoctrineCollectionFactoryDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineCollectionFactoryDecorator extends AbstractCollectionFactoryDecorator
{
    private $entityManager;

    /**
     * DoctrineCollectionFactoryDecorator constructor.
     *
     * @param CollectionFactoryInterface $collectionFactory
     * @param EntityManagerInterface     $entityManager
     */
    public function __construct(CollectionFactoryInterface $collectionFactory, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($collectionFactory);
    }

    /**
     * @inheritDoc
     */
    public function create(array $operations = []) : CollectionInterface
    {
        $collection = parent::create($operations);

        return new DoctrineCollectionDecorator($collection, $this->entityManager);
    }
}