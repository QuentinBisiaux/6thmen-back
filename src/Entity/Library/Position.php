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
        'PG'    => ['Meneur'],
        'SG'    => ['Arriere'],
        'G'     => ['Meneur', 'Arriere'],
        'G-F'   => ['Meneur', 'Arriere', 'Ailier'],
        'F-G'   => ['Meneur', 'Arriere', 'Ailier'],
        'SF'    => ['Ailier'],
        'PF'    => ['AilierFort'],
        'F'     => ['Ailier', 'AilierFort'],
        'C'     => ['Pivot'],
        'F-C'   => ['Ailier', 'AilierFort', 'Pivot'],
        'C-F'   => ['Ailier', 'AilierFort', 'Pivot'],
    ];

    static function getPositionByAbbreviation(string $abbreviation): array
    {
        return self::POSITION_MATRIX[$abbreviation];
    }

}