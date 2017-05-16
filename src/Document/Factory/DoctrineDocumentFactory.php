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
use Doctrine\Common\Persistence\Mapping\MappingException;

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
     * @inheritDoc
     */
    public function createDocument(string $documentName, array $documentData): DocumentInterface
    {
        /**
         * @var DocumentInterface $document
         */
        $document = $this->getClassMetadata($documentName)->getReflectionClass()->newInstance();

        return $this->updateDocument($document, $documentData);
    }

    /**
     * @inheritDoc
     */
    public function updateDocument(DocumentInterface $document, array $documentData): DocumentInterface
    {
        $documentName = get_class($document);
        $classMetadata = $this->getClassMetadata($documentName);
        foreach ($classMetadata->associationMappings as $fieldName => $mapping) {
          if (isset($mapping['discriminatorField'])) {
            $discriminatorField = $mapping['discriminatorField'];
            if (!isset($documentData[$fieldName])) {
              $documentData[$fieldName] = [];
            }
            if (!isset($documentData[$fieldName][$discriminatorField])) {
              $assosiation = $classMetadata->reflFields[$fieldName]->getValue($document);
              $documentData[$fieldName][$discriminatorField] = $this->getClassMetadata(get_class($assosiation))->reflFields[$discriminatorField]->getValue($assosiation);
            }
          }
        }
        try {
          $data = $this->documentManager->getHydratorFactory()->getHydratorFor($documentName)->hydrate($document, $documentData);
        } catch (MappingException $me) {
          throw new \Exception('Mapping failed', 0, $me);
        }
        if ($document instanceof Proxy) {
            $document->__isInitialized__ = true;
            $document->__setInitializer(null);
            $document->__setCloner(null);
            // lazy properties may be left uninitialized
            $properties = $document->__getLazyProperties();
            foreach ($properties as $propertyName => $property) {
                if ( ! isset($document->$propertyName)) {
                    $document->$propertyName = $properties[$propertyName];
                }
            }
        }
        return $document;
    }
}
