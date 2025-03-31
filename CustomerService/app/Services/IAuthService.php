<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;

interface IAuthService
{
    public function registerUser(RegisterUserRequest $request);

    public function login(LoginRequest $request);

    public function logout(Request $request);

    public function changePassword(ChangePasswordRequest $request);

    public function comparePasswordsFromRequest($passsword, $repeatPassword);

    public function validateUser($user, $isCorrectPassword);

    public function deleteAccount(DeleteAccountRequest $request, int $userId);

    public function returnUserWithToken($user, $token);

    public function createToken($user);
}
