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

namespace Vain\Doctrine\Driver\Postgresql;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use \PDO as PdoInstance;

/**
 * Class DoctrinePostgresqlDriver
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DoctrinePostgresqlDriver extends AbstractPostgreSQLDriver
{
    private $pdoInstance;

    /**
     * PostgresqlDoctrineDriver constructor.
     *
     * @param PdoInstance $pdoInstance
     */
    public function __construct(PdoInstance $pdoInstance)
    {
        $this->pdoInstance = $pdoInstance;
    }

    /**
     * @inheritDoc
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return $this->pdoInstance;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'pdo_pgsql';
    }
}