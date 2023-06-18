<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class LotteryDoneEvent extends Event
{
    public const NAME = 'lottery.done';


    public function __construct(
        protected array $result,
    )
    {}

    public function getResult(): array
    {
        return $this->result;
    }

}