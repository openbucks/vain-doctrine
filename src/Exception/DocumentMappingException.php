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

use Vain\Core\Document\DocumentInterface;
use Vain\Core\Document\Factory\DocumentFactoryInterface;

/**
 * Class DocumentMappingException
 *
 * @author Nazar Ivanenko <nivanenko@gmail.com>
 */
class DocumentMappingException extends DocumentFactoryException
{

    private $document;

    /**
     * DocumentMappingException constructor.
     *
     * @param DocumentFactoryInterface  $documentFactory
     * @param DocumentInterface         $document
     * @param \Exception|null           $previous = null
     */
    public function __construct(
      DocumentFactoryInterface $documentFactory,
      DocumentInterface $document,
      \Exception $previous = null
    ) {
        $this->document = $document;
        parent::__construct($documentFactory, sprintf('Mapping exception in %s', $document->getDocumentName()), 422, $previous);
    }
}
