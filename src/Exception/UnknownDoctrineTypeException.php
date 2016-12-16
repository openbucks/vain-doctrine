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

use Vain\Core\Connection\Exception\ConnectionFactoryException;
use Vain\Core\Connection\Factory\ConnectionFactoryInterface;

/**
 * Class UnknownDoctrineDriverException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class UnknownDoctrineTypeException extends ConnectionFactoryException
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
            sprintf('Cannot create doctrine connection of unknown type %s', $driver)
        );
    }
}
