<?php

namespace Repositories;

use Exception;
use Models\Score;
use PDO;

class ScoreRepository extends Repository
{
    public function getScore($id): ?Score
    {
        try {
            $statement = $this->connection->prepare(
                "SELECT user_id, score FROM scores WHERE user_id = :user_id"
            );
            $statement->execute([
                'user_id' => $id
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Score(
                    $result['user_id'],
                    $result['score']
                );
            }
            return null;
        } catch (Exception) {
            return null;
        }
    }

    public function addScore($score): ?Score
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO scores (user_id, score) VALUES (:user_id, :score)"
            );
            $statement->execute([
                'user_id' => $score->user_id,
                'score' => $score->score
            ]);
            return $score;
        } catch (Exception) {
            return null;
        }
    }

    public function updateScore($score): ?int
    {
        try {
            $statement = $this->connection->prepare(
                "UPDATE scores SET score = :score WHERE user_id = :user_id"
            );
            $statement->execute([
                'user_id' => $score->user_id,
                'score' => $score->score
            ]);
            return $score->score;
        } catch (Exception) {
            return null;
        }
    }

    public function deleteScore($userId): ?bool
    {
        try {
            $statement = $this->connection->prepare(
                "DELETE FROM scores WHERE user_id = :user_id"
            );
            $statement->execute([
                'user_id' => $userId
            ]);
            return true;
        } catch (Exception) {
            return false;
        }
    }
}
