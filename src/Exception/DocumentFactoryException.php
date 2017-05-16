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

namespace Vain\Doctrine\Exception;

use Vain\Core\Document\Factory\DocumentFactoryInterface;
use Vain\Core\Exception\AbstractCoreException;

/**
 * Class DocumentFactoryException
 *
 * @author Nazar Ivanenko <nivanenko@gmail.com>
 */
class DocumentFactoryException extends AbstractCoreException
{
    private $documentFactory;

    /**
     * DocumentFactoryException constructor.
     *
     * @param DocumentFactoryInterface  $documentFactory
     * @param string                    $message
     * @param int                       $code
     * @param \Exception|null           $previous
     */
    public function __construct(
        DocumentFactoryInterface $documentFactory,
        string $message,
        int $code = 500,
        \Exception $previous = null
    ) {
        $this->documentFactory = $documentFactory;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return DocumentFactoryInterface
     */
    public function getDocumentOperationFactory(): DocumentFactoryInterface
    {
        return $this->documentFactory;
    }
}
