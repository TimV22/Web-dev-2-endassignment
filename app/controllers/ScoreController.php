<?php

namespace Controllers;

use Services\ScoreService;

class ScoreController extends Controller
{
    private ScoreService $scoreService;

    public function __construct()
    {
        $this->scoreService = new ScoreService();
    }

    public function getScore(): void
    {
        $decoded = $this->checkForJwt();
        if ($decoded) {
            $score = $this->scoreService->getScore($decoded->data->id);
            if ($score) {
                $response = array(
                    "message" => "Successful request.",
                    "score" => $score->score
                );
                $this->respond($response);
            } else {
                $this->respondWithError(401, "No score found");
            }
        }
    }

    public function create(): void
    {
        $decoded = $this->checkForJwt();
        if ($decoded) {
            $score = $this->createObjectFromPostedJson('Models\Score');
            if ($score) {
                $score->user_id = $decoded->data->id;
                if ($this->scoreService->getScore($decoded->data->id)) {
                    $this->respondWithError(401, "Score already exists");
                }
                $score = $this->scoreService->addScore($score);
                if ($score) {
                    $response = array(
                        "message" => "Successful request.",
                        "score" => $score->score
                    );
                    $this->respond($response);
                } else {
                    $this->respondWithError(401, "No score found");
                }
            } else {
                $this->respondWithError(401, "No score found");
            }
        }
    }

    public function update(): void
    {
        $decoded = $this->checkForJwt();
        if ($decoded) {
            $score = $this->createObjectFromPostedJson('Models\Score');
            if ($score) {
                $score->user_id = $decoded->data->id;
                $score = $this->scoreService->updateScore($score);
                if ($score) {
                    $response = array(
                        "message" => "Successful updated score.",
                        "score" => $score
                    );
                    $this->respond($response);
                } else {
                    $this->respondWithError(401, "No score found");
                }
            } else {
                $this->respondWithError(401, "No score found");
            }
        }
    }

    public function addBetToScore($bet): void
    {
        $decoded = $this->checkForJwt();
        if ($decoded) {
            $score = $this->scoreService->getScore($decoded->data->id);
            if ($score) {
                $score->score += $bet;
                $score = $this->scoreService->updateScore($score);
                if ($score) {
                    $response = array(
                        "message" => "Successful added bet to score.",
                        "score" => $score
                    );
                    $this->respond($response);
                } else {
                    $this->respondWithError(401, "No score found");
                }
            } else {
                $this->respondWithError(401, "No score found");
            }
        }
    }

    public function removeBetFromScore($bet): void
    {
        $decoded = $this->checkForJwt();
        if ($decoded) {
            $score = $this->scoreService->getScore($decoded->data->id);
            if ($score) {
                $score->score -= $bet;
                $score = $this->scoreService->updateScore($score);
                if ($score) {
                    $response = array(
                        "message" => "Successful subtracted bet from score.",
                        "score" => $score
                    );
                    $this->respond($response);
                } else {
                    $this->respondWithError(401, "No score found");
                }
            } else {
                $this->respondWithError(401, "No score found");
            }
        }
    }

    public function delete(): void
    {
        $decoded = $this->checkForJwt();
        if ($decoded) {
            $user_id = $decoded->data->id;
            if ($this->scoreService->getScore($user_id)) {
                $score = $this->scoreService->deleteScore($user_id);
                if ($score) {
                    $response = array(
                        "message" => "Successful deleted score."
                    );
                    $this->respond($response);
                } else {
                    $this->respondWithError(401, "No score found");
                }
            } else {
                $this->respondWithError(401, "No score found");
            }
        }
    }

}
