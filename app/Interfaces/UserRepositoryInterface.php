<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function signUp(array $dataUser, array $dataPwUser);
    public function getUserByEmail(string $email);
}
