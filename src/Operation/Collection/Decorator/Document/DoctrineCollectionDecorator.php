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

namespace Vain\Doctrine\Operation\Collection\Decorator\Document;

use Vain\Doctrine\Document\DoctrineDocumentManager;
use Vain\Core\Operation\Collection\OperationCollectionInterface;
use Vain\Core\Operation\Collection\Decorator\AbstractOperationCollectionDecorator;
use Vain\Core\Result\ResultInterface;
use Vain\Doctrine\Operation\Collection\Result\DoctrineCollectionFailedResult;

/**
 * Class DoctrineCollectionDecorator
 *
 * @author Nazar Ivenenko <nivanenko@gmail.com>
 */
class DoctrineCollectionDecorator extends AbstractOperationCollectionDecorator
{
    private $documentManager;

    /**
     * DoctrineCollectionDecorator constructor.
     *
     * @param OperationCollectionInterface   $collection
     * @param DoctrineDocumentManager        $documentManager
     */
    public function __construct(OperationCollectionInterface $collection, DoctrineDocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
        parent::__construct($collection);
    }

    /**
     * @inheritDoc
     */
    public function execute() : ResultInterface
    {
        try {
            $this->documentManager->init();

            $result = parent::execute();
            if (false === $result->getStatus()) {
                return $result;
            }

            $this->documentManager->flush();
        } catch (\Exception $exception) {
            return new DoctrineCollectionFailedResult($exception);
        }

        return $result;
    }
}
