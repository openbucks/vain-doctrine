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

use Vain\Connection\Exception\ConnectionFactoryException;
use Vain\Connection\Factory\ConnectionFactoryInterface;

/**
 * Class UnknownDriverConnectionFactoryException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class UnknownDriverConnectionFactoryException extends ConnectionFactoryException
{
    /**
     * UnknownDriverConnectionFactoryException constructor.
     *
     * @param ConnectionFactoryInterface $connectionFactory
     * @param string                     $driver
     */
    public function __construct(ConnectionFactoryInterface $connectionFactory, $driver)
    {
        parent::__construct(
            $connectionFactory,
            sprintf('Cannot create doctrine connection of unknown driver %s', $driver),
            0,
            null
        );
    }
}