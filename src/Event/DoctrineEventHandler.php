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

    /**
     * DoctrineEventHandler constructor.
     *
     * @param ResolverInterface      $resolver
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ResolverInterface $resolver, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

        return $this;
    }
}
