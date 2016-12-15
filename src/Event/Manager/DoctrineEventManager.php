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

namespace Vain\Doctrine\Event\Manager;

use Doctrine\Common\EventManager;
use Vain\Core\Time\Factory\TimeFactoryInterface;

/**
 * Class DoctrineEventManager
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineEventManager extends EventManager
{
    private $timeFactory;

    /**
     * DoctrineEventManager constructor.
     *
     * @param TimeFactoryInterface $timeFactory
     */
    public function __construct(TimeFactoryInterface $timeFactory)
    {
        $this->timeFactory = $timeFactory;
    }

    /**
     * @return TimeFactoryInterface
     */
    public function getTimeFactory(): TimeFactoryInterface
    {
        return $this->timeFactory;
    }
}
