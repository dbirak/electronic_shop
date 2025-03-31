<?php

namespace App\Services;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Mails\DeleteAccountMail;
use App\Http\Mails\RegisterMail;
use App\Http\Mails\ResetPasswordMail;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Repositories\IUserRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService implements IAuthService
{
    protected $userRepository;

    public function __construct(IUserRepository $iUserRepository)
    {
        $this->userRepository = $iUserRepository;
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $this->comparePasswordsFromRequest($request['password'], $request['repeat_password']);
        $user = $this->userRepository->createUser($request);

        $token = $this->createToken($user);

        return $this->returnUserWithToken($user, $token);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->getUserByEmail($request['email']);

        if (!$user) $this->validateUser($user, "");

        $isCorrectPassword = $this->userRepository->comparePassword($request['password'], $user);

        $this->validateUser($user, $isCorrectPassword);

        $token = $this->createToken($user);

        return $this->returnUserWithToken($user, $token);
    }

    public function logout(Request $request)
    {
        $this->userRepository->deleteToken($request);
    }

    public function createToken($user)
    {
        return $this->userRepository->createToken($user);
    }

    public function returnUserWithToken($user, $token)
    {
        $res = [
            'token' => $token,
            'user_details' => new UserResource($this->userRepository->getUserById($user['id'])),
        ];

        return $res;
    }

    public function comparePasswordsFromRequest($passsword, $repeatPassword)
    {
        if ($passsword !== $repeatPassword) throw new AuthenticationException();
    }

    public function validateUser($user, $isCorrectPassword)
    {
        if (!$user || !$isCorrectPassword) throw new AuthenticationException();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $this->userRepository->getUserById($request->user()->id);

        if (!$this->userRepository->comparePassword($request['password'], $user)) throw new Exception("Obecne hasło jest niepoprawne!");
        $this->userRepository->changePassword($request['new_password'], $user);

        return $res = ['message' => 'Hasło zostało zmienione!'];
    }

    public function deleteAccount(DeleteAccountRequest $request, int $userId)
    {
        if (!Hash::check($request['password'], $request->user()->password)) throw new AuthorizationException("Niepoprawne hasło!");

        $user = $this->userRepository->getUserById($userId);

        $this->userRepository->deleteAccount($userId);
    }
}
