<?php

declare(strict_types=1);

namespace App\DataProvider;

class ContainerDataProvider
{
    public const WORK_TYPE = 'work_type';
    public const WORK_CTO = 'work_cto';
    public const BID = 'bid';

    public static function isContainer(string $container): bool
    {
        $allContainer = [
            self::WORK_TYPE,
            self::WORK_CTO,
            self::BID
        ];

        return in_array($container, $allContainer);
    }
}