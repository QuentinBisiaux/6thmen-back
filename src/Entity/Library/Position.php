<?php

namespace App\Entity\Library;

class Position
{
    const BASE_POSITION = [
        1 => 'Meneur',
        2 => 'Arrière',
        3 => 'Ailier',
        4 => 'Ailier Fort',
        5 => 'Pivot',
    ];
    const POSITION_MATRIX = [
        'PG' => ['Meneur'],
        'SG' => ['Arrière'],
        'G' => ['Meneur', 'Arrière'],
        'F' => ['Ailier', 'Ailier Fort'],
        'SF' => ['Ailier'],
        'PF' => ['Ailier Fort'],
        'F-C' => ['Ailier', 'Ailier Fort', 'Pivot'],
        'C' => ['Pivot'],
    ];

    static function getPositionByAbbreviation(string $abbreviation): array
    {
        return self::POSITION_MATRIX[$abbreviation];
    }

}