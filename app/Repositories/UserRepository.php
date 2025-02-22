<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\PwUser;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function signUp(array $dataUser, array $dataPwUser)
    {
        $user = User::create($dataUser);
        $user->refresh();
        $dataPwUser['id'] = $user->user_id;

        PwUser::create($dataPwUser);

        return $user;
    }


    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)
            ->join('pw_users', 'users.users_id', '=', 'pw_users.id')
            ->select('users.*', 'pw_users.password')
            ->first();
    }
}
