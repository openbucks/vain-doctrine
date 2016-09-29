<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   INFRA
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/INFRA
 */

namespace Vain\Doctrine\Connection;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use Vain\Connection\ConnectionInterface;
use Vain\Pdo\Connection\PdoConnectionInterface;

/**
 * Class DoctrinePostgresqlConnection
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrinePostgresqlConnection extends AbstractPostgreSQLDriver implements ConnectionInterface
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
        return 'pdo_pgsql';
    }

    /**
     * @inheritDoc
     */
    public function establish()
    {
        return $this->pdoConnection->establish();
    }
}