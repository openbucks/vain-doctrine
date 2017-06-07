<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   Vain-doctrine
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vain\Doctrine\Type;

use Doctrine\ODM\MongoDB\Types\Type;
use Vain\Core\Locale\UsLocale;
use Vain\Core\Time\Time;
use Vain\Core\Time\TimeInterface;
use Vain\Core\Time\Zone\TimeZone;

/**
 * Class TimeDocumentType
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TimeDocumentType extends Type
{
    public function convertToDatabaseValue($value)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof TimeInterface) {
            return $value->toDateTime();
        }

        throw new \InvalidArgumentException(sprintf('%s is not a properly formatted TIME type.', get_class($value)));
    }

    public function convertToPHPValue($value)
    {
        if ($value === null || $value instanceof TimeInterface) {
            return $value;
        }

        $dateTime = new \DateTime($value);
        $timeZone = $dateTime->getTimezone()->getName();
        $timeZone = new TimeZone(
            $timeZone,
            $timeZone,
            (new \DateTime($value))->setTimezone(new \DateTimeZone($timeZone))->format(
                'T'
            )
        );
        $targetZone = new TimeZone(
            'Ameriza/Los_Angeles',
            'Ameriza/Los_Angeles',
            (new \DateTime($value))->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format(
                'T'
            )
        );

        return (new Time(
            $value, new UsLocale(), $timeZone,
            (new Time('now', new UsLocale(), $timeZone))
                ->setTimezone($targetZone)
        ))->setTimezone($targetZone);
    }
}