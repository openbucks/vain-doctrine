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

namespace Vain\Doctrine\Operation\Collection\Factory\Decorator\Document;

use Doctrine\ODM\MongoDB\DocumentManager;
use Vain\Doctrine\Operation\Collection\Decorator\Document\DoctrineCollectionDecorator;
use Vain\Core\Operation\Collection\OperationCollectionInterface;
use Vain\Core\Operation\Collection\Factory\OperationCollectionFactoryInterface;
use Vain\Core\Operation\Collection\Factory\Decorator\AbstractOperationCollectionFactoryDecorator;

/**
 * Class DoctrineCollectionFactoryDecorator
 *
 * @author Nazar Ivenenko <nivanenko@gmail.com>
 */
class DoctrineCollectionFactoryDecorator extends AbstractOperationCollectionFactoryDecorator
{
    private $documentManager;

    /**
     * DoctrineCollectionFactoryDecorator constructor.
     *
     * @param OperationCollectionFactoryInterface $collectionFactory
     * @param DocumentManager     $documentManager
     */
    public function __construct(OperationCollectionFactoryInterface $collectionFactory, DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
        parent::__construct($collectionFactory);
    }

    /**
     * @inheritDoc
     */
    public function create(array $operations = []) : OperationCollectionInterface
    {
        $collection = parent::create($operations);

        return new DoctrineCollectionDecorator($collection, $this->documentManager);
    }
}
