<?php

namespace Models;

class User
{
    public int $id;
    public string $username;
    public string $password;
    public string $email;
    public int $role;

    public function __construct($id = 0, $username = "", $password = "", $email = "", $role = 0)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return match ($this->role) {
            1 => "admin",
            2 => "user",
            default => "unknown",
        };
    }
}