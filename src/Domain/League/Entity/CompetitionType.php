<?php

namespace App\Domain\League\Entity;

class CompetitionType
{
    const COMPETITION_REGULAR_SEASON = 'Regular Season';

    const COMPETITION_PLAYOFF = 'Playoff';

    const COMPETITION_DRAFT = 'Draft';

    const COMPETITION_OFF_SEASON = 'Off Season';

    const COMPETITION_TYPES = [
        self::COMPETITION_REGULAR_SEASON,
        self::COMPETITION_PLAYOFF,
        self::COMPETITION_DRAFT,
        self::COMPETITION_OFF_SEASON,
    ];

}