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

namespace Vain\Doctrine\Event;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Vain\Core\Event\EventInterface;
use Vain\Core\Event\Handler\AbstractEventHandler;
use Vain\Core\Event\Resolver\EventResolverInterface;

/**
 * Class DoctrineEventHandler
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEventHandler extends AbstractEventHandler
{

    private $entityManager;

    private $documentManager;

    /**
     * DoctrineEventHandler constructor.
     *
     * @param EventResolverInterface      $resolver
     * @param EntityManagerInterface      $entityManager
     * @param DocumentManager             $documentManager
     */
    public function __construct(EventResolverInterface $resolver, EntityManagerInterface $entityManager, DocumentManager $documentManager)
    {
        $this->entityManager = $entityManager;
        $this->documentManager = $documentManager;
        parent::__construct($resolver);
    }

    /**
     * @param EventInterface $event
     *
     * @return DoctrineEventHandler
     */
    public function onResponse(EventInterface $event)
    {
        $this->entityManager->clear();
        $this->documentManager->clear();

        return $this;
    }
}
