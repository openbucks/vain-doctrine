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

namespace Vain\Doctrine\Document\Factory;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadataInfo as ClassMetadata;
use Doctrine\ODM\MongoDB\DocumentManager;
use Vain\Core\Document\DocumentInterface;
use Vain\Core\Document\Factory\DocumentFactoryInterface;

/**
 * Class DoctrineDocumentFactory
 *
 * @author Nazar Ivanenko <nivanenko@gmail.com>
 */
class DoctrineDocumentFactory implements DocumentFactoryInterface
{
    private $documentManager;

    /**
     * DoctrineDocumentFactory constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @param string $documentName
     *
     * @return ClassMetadata
     */
    public function getClassMetadata(string $documentName): ClassMetadata
    {
        return $this->documentManager->getClassMetadata($documentName);
    }

    /**
     * @param DocumentInterface $document
     * @param ClassMetadata     $classMetadata
     * @param array             $documentData
     *
     * @return DocumentInterface
     */
    public function populate(
        DocumentInterface $document,
        ClassMetadata $classMetadata,
        array $documentData
    ): DocumentInterface {
        $parsedData = [];
        foreach ($documentData as $column => $value) {
            if (array_key_exists($column, $classMetadata->fieldMappings)) {
                $parsedData[$column] = $value;
                continue;
            }
            foreach ($classMetadata->associationMappings as $associationMapping) {
                if (false === $associationMapping['type'] <= 2) {
                    continue;
                }
                if ($column !== $associationMapping['joinColumns'][0]['name']) {
                    continue;
                }
                if (null === ($associatedDocument = $this->documentManager->find(
                        $associationMapping['targetDocument'],
                        $value
                    ))
                ) {
                    continue;
                }
                $parsedData[$associationMapping['fieldName']] = $associatedDocument;
            }
        }

        return $document->fromArray($parsedData);
    }

    /**
     * @inheritDoc
     */
    public function createDocument(string $documentName, array $documentData): DocumentInterface
    {
        $classMetadata = $this->getClassMetadata($documentName);
        /**
         * @var DocumentInterface $document
         */
        $document = $classMetadata->getReflectionClass()->newInstance();

        return $this->populate($document, $classMetadata, $documentData);
    }

    /**
     * @inheritDoc
     */
    public function updateDocument(DocumentInterface $document, array $documentData): DocumentInterface
    {
        $classMetadata = $this->getClassMetadata(get_class($document));

        return $this->populate($document, $classMetadata, $documentData);
    }
}
