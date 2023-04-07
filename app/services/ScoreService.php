<?php

namespace Services;

use Models\Score;
use Repositories\ScoreRepository;

class ScoreService
{
    private ScoreRepository $scoreRepository;

    public function __construct()
    {
        $this->scoreRepository = new ScoreRepository();
    }

    public function getScore(int $id): ?Score
    {
        return $this->scoreRepository->getScore($id);
    }

    public function addScore(Score $score): ?Score
    {
        return $this->scoreRepository->addScore($score);
    }

    public function updateScore(Score $score): ?int
    {
        return $this->scoreRepository->updateScore($score);
    }

    public function deleteScore(int $userId): bool
    {
        return $this->scoreRepository->deleteScore($userId);
    }
}
