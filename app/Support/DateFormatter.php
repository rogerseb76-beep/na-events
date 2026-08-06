<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Illuminate\Support\Str;

class DateFormatter
{
    public static function short(
        CarbonInterface|DateTimeInterface|string|null $date
    ): string {
        $carbon = self::toCarbon($date);

        return $carbon
            ? $carbon->format('d/m/Y')
            : '';
    }

    public static function long(
        CarbonInterface|DateTimeInterface|string|null $date,
        bool $capitalize = false
    ): string {
        $carbon = self::toCarbon($date);

        if (! $carbon) {
            return '';
        }

        $formatted = $carbon
            ->locale('fr')
            ->translatedFormat('l j F Y');

        return $capitalize
            ? Str::ucfirst($formatted)
            : $formatted;
    }

    public static function dateTime(
        CarbonInterface|DateTimeInterface|string|null $date
    ): string {
        $carbon = self::toCarbon($date);

        return $carbon
            ? $carbon->format('d/m/Y à H\hi')
            : '';
    }

    public static function time(
        string|CarbonInterface|DateTimeInterface|null $time
    ): string {
        if ($time === null || $time === '') {
            return '';
        }

        if (
            $time instanceof CarbonInterface
            || $time instanceof DateTimeInterface
        ) {
            return Carbon::instance($time)->format('H\hi');
        }

        try {
            return Carbon::parse($time)->format('H\hi');
        } catch (\Throwable) {
            return str_replace(':', 'h', substr($time, 0, 5));
        }
    }

    public static function timeRange(
        string|CarbonInterface|DateTimeInterface|null $start,
        string|CarbonInterface|DateTimeInterface|null $end,
        string $separator = ' – '
    ): string {
        return self::time($start)
            . $separator
            . self::time($end);
    }

    private static function toCarbon(
        CarbonInterface|DateTimeInterface|string|null $date
    ): ?Carbon {
        if ($date === null || $date === '') {
            return null;
        }

        if ($date instanceof CarbonInterface) {
            return Carbon::instance($date);
        }

        if ($date instanceof DateTimeInterface) {
            return Carbon::instance($date);
        }

        try {
            return Carbon::parse($date);
        } catch (\Throwable) {
            return null;
        }
    }
}
