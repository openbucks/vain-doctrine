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

namespace Vain\Doctrine\Document;

use Doctrine\Common\EventManager;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\ORMException;
use Vain\Doctrine\Exception\LevelIntegrityDoctrineException;
use Vain\Core\Time\Factory\TimeFactoryInterface;

/**
 * Class DoctrineDocumentManager
 *
 * @author Nazar Ivanenko <nivanenko@gmail.com>
 */
class DoctrineDocumentManager extends DocumentManager
{
    /**
     * @var TimeFactoryInterface
     */
    private $timeFactory;

    private $flushLevel = 0;

    /**
     * DoctrineDocumentManager constructor.
     *
     * @param Connection           $conn
     * @param Configuration        $config
     * @param EventManager         $eventManager
     * @param TimeFactoryInterface $timeFactory
     */
    protected function __construct(
        Connection $conn,
        Configuration $config,
        EventManager $eventManager,
        TimeFactoryInterface $timeFactory
    ) {
        $this->timeFactory = $timeFactory;
        parent::__construct($conn, $config, $eventManager);
    }

    /**
     * @param                      $conn
     * @param Configuration        $config
     * @param EventManager         $eventManager
     * @param TimeFactoryInterface $timeFactory
     *
     * @return DoctrineDocumentManager
     * @throws ORMException
     */
    public static function createWithTimeFactory(
        $conn,
        Configuration $config,
        EventManager $eventManager,
        TimeFactoryInterface $timeFactory
    ) {
        if (!$config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        switch (true) {
            case ($conn instanceof Connection):
                if ($eventManager !== null && $conn->getEventManager() !== $eventManager) {
                    throw ORMException::mismatchedEventManager();
                }
                break;

            default:
                throw new \InvalidArgumentException("Invalid argument: " . $conn);
        }

        return new DoctrineDocumentManager($conn, $config, $conn->getEventManager(), $timeFactory);
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (0 <= $this->flushLevel) {
            $this->flushLevel++;
            return $this;
        }

        throw new LevelIntegrityDoctrineException($this, $this->flushLevel);
    }

    /**
     * @inheritDoc
     */
    public function flush($document = null, array $options = [])
    {
        $this->flushLevel--;

        if (0 < $this->flushLevel) {
            return $this;
        }

        if (0 > $this->flushLevel) {
            throw new LevelIntegrityDoctrineException($this, $this->flushLevel);
        }

        parent::flush($document);

        return $this;
    }

    /**
     * @return TimeFactoryInterface
     */
    public function getTimeFactory()
    {
        return $this->timeFactory;
    }
}
