<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Repositories\IUserRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\IRoleRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService implements IAuthService
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(IUserRepository $iUserRepository, IRoleRepository $iRoleRepository)
    {
        $this->userRepository = $iUserRepository;
        $this->roleRepository = $iRoleRepository;
    }

    public function registerManager(RegisterUserRequest $request)
    {
        $this->comparePasswordsFromRequest($request['password'], $request['repeat_password']);
        $user = $this->userRepository->createManager($request);

        $token = $this->createToken($user, 1);

        return $this->returnUserWithToken($user, $token);
    }

    public function registerModerator(RegisterUserRequest $request)
    {
        $this->comparePasswordsFromRequest($request['password'], $request['repeat_password']);
        $user = $this->userRepository->createModerator($request);

        $token = $this->createToken($user, 2);

        return $this->returnUserWithToken($user, $token);
    }

    public function registerSeller(RegisterUserRequest $request)
    {
        $this->comparePasswordsFromRequest($request['password'], $request['repeat_password']);
        $user = $this->userRepository->createSeller($request);

        $token = $this->createToken($user, 3);

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
        $role = $this->roleRepository->getRoleById($user['role_id']);
        return $this->userRepository->createToken($user, $role);
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
