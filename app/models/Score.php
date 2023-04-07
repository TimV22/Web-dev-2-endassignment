<?php

namespace Models;

class Score
{
    public int $user_id;
    public int $score;

    public function __construct($user_id = 0, $score = 0)
    {
        $this->user_id = $user_id;
        $this->score = $score;
    }
}
