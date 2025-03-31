<?php

namespace App\Repositories;

use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

interface IUserRepository
{

    public function getUserByEmail(string $email);

    public function comparePassword(string $password, User $user);

    public function createToken(User $user);

    public function deleteToken(Request $request);

    public function createUser(RegisterUserRequest $request);

    public function getUserById(int $id);

    public function changePassword(String $password, User $user);

    public function findResetPasswordUsers(string $email);

    public function deleteResetPasswordUser($user);

    public function createForgotPasswordToken(string $token, string $email);

    public function findByResetToken(string $token);

    public function deleteAccount(int $userId);
}
