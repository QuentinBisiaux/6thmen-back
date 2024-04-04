<?php

namespace App\Domain\Player\Entity;

class Position
{
    const BASE_POSITION_BY_NUMBER = [
        1 => 'Meneur',
        2 => 'Arrière',
        3 => 'Ailier',
        4 => 'Ailier Fort',
        5 => 'Pivot',
    ];

    const NUMBER_POSITION_BY_POSITION = [
        'Meneur' => 1,
        'Arrière' => 2,
        'Ailier' => 3,
        'Ailier Fort' => 4,
        'Pivot' => 5,
    ];

    const POSITION_MATRIX = [
        'PG'    => ['Meneur'],
        'SG'    => ['Arrière'],
        'G'     => ['Meneur', 'Arrière'],
        'G-F'   => ['Meneur', 'Arrière', 'Ailier'],
        'F-G'   => ['Meneur', 'Arrière', 'Ailier'],
        'SF'    => ['Ailier'],
        'PF'    => ['Ailier Fort'],
        'F'     => ['Ailier', 'Ailier Fort'],
        'C'     => ['Pivot'],
        'F-C'   => ['Ailier', 'Ailier Fort', 'Pivot'],
        'C-F'   => ['Ailier', 'Ailier Fort', 'Pivot'],
    ];

    const POSITION_NUMBER_MATRIX = [
        'PG'    => [1],
        'SG'    => [2],
        'G'     => [1, 2],
        'G-F'   => [1, 2, 3],
        'F-G'   => [1, 2, 3],
        'SF'    => [3],
        'PF'    => [4],
        'F'     => [3, 4],
        'C'     => [5],
        'F-C'   => [3, 4, 5],
        'C-F'   => [3, 4, 5],
    ];

    static function getPositionByAbbreviation(string $abbreviation): array
    {
        return self::POSITION_MATRIX[$abbreviation];
    }

    static function getPositionByArrayOfNumber(array $positionsNumbers): array
    {
        $positions = [];
        foreach ($positionsNumbers as $positionNumber) {
            $positions[] = self::BASE_POSITION_BY_NUMBER[$positionNumber];
        }

        return $positions;
    }

}