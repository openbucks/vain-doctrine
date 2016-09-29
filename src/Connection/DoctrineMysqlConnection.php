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

namespace Vain\Doctrine\Connection;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Vain\Pdo\Connection\PdoConnectionInterface;

/**
 * Class DoctrineMysqlConnection
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrineMysqlConnection extends AbstractMySQLDriver
{
    private $pdoConnection;

    /**
     * PostgresqlDoctrineDriver constructor.
     *
     * @param PdoConnectionInterface $pdoConnection
     */
    public function __construct(PdoConnectionInterface $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    /**
     * @inheritDoc
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return $this->establish();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'pdo_mysql';
    }

    /**
     * @inheritDoc
     */
    public function establish()
    {
        return $this->pdoConnection->establish();
    }
}