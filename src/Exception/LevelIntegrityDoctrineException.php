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

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LevelIntegrityDoctrineException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class LevelIntegrityDoctrineException extends EntityManagerException
{
    /**
     * LevelIntegrityDoctrineException constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param int                    $level
     */
    public function __construct(EntityManagerInterface $entityManager, int $level)
    {
        parent::__construct($entityManager, sprintf('Level integrity check exception for level %d', $level));
    }
}