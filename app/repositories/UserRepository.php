<?php

namespace Repositories;

use Exception;
use Models\User;
use PDO;

class UserRepository extends Repository
{

    public function login($email, $password): ?User
    {
        try {
            $statement = $this->connection->prepare(
                "SELECT * FROM users WHERE email = :email AND password = :password"
            );
            $statement->execute([
                'email' => strtolower($email),
                'password' => $password
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new User(
                    $result['id'],
                    $result['username'],
                    $result['password'],
                    $result['email'],
                    $result['role']
                );
            }
            return null;
        } catch (Exception) {
            return null;
        }
    }

    public function register(mixed $user): ?User
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)"
            );
            $statement->execute([
                'username' => $user->username,
                'password' => $user->password,
                'email' => strtolower($user->email),
                'role' => $user->role
            ]);

            //get the last inserted id
            $id = $this->connection->lastInsertId();
            $user->id = $id;
            return $user;
        } catch (Exception) {
            return null;
        }
    }

    public function userExists($email): bool
    {
        try {
            $statement = $this->connection->prepare(
                "SELECT id, username, password, email, role FROM users WHERE email = :email"
            );
            $statement->execute([
                'email' => strtolower($email)
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return true;
            }
            return false;
        } catch (Exception) {
            return false;
        }
    }

    public function getScore($id): ?int
    {
        try {
            $statement = $this->connection->prepare(
                "SELECT score FROM users WHERE id = :id"
            );
            $statement->execute([
                'id' => $id
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['score'];
            }
            return null;
        } catch (Exception) {
            return null;
        }
    }

}
