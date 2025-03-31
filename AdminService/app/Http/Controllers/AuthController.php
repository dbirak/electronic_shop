<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\IAuthService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(IAuthService $iAuthService)
    {
        $this->authService = $iAuthService;
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $res = $this->authService->registerUser($request);
        return response($res, 201);
    }

    public function login(LoginRequest $request)
    {
        try {
            $res = $this->authService->login($request);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof AuthenticationException)
                return response(['message' => 'Nieprawidłowy adres email lub hasło!'], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $res = $this->authService->logout($request);
            return response(['message' => 'Wylogowanie przebiegło pomyślnie!'], 200);
        } catch (Exception $e) {
            if ($e instanceof AuthenticationException)
                return response(['message' => 'Nieuwierzytelniony!'], 401);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $res = $this->authService->changePassword($request);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof Exception)
                return response(['message' => $e->getMessage()], 401);
        }
    }

    public function deleteAccount(DeleteAccountRequest $request)
    {
        try {
            $res = $this->authService->deleteAccount($request, $request->user()->id);
            return response($res, 204);
        } catch (Exception $e) {
            if ($e instanceof ConflictException)
                throw $e;
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
        }
    }
}
