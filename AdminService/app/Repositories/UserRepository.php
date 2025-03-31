<?php

namespace App\Repositories;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function comparePassword(string $password, User $user)
    {
        return Hash::check($password, $user->password);
    }

    public function createToken(User $user)
    {
        return $user->createToken('token', ['admin'])->plainTextToken;
    }

    public function deleteToken(Request $request)
    {
        $request->user()->tokens()->delete();
    }

    public function createUser(RegisterUserRequest $request)
    {
        $user = User::create([
            'first_name' => ucfirst(strtolower($request->first_name)),
            'last_name' => ucfirst(strtolower($request->last_name)),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2
        ]);

        return $user;
    }

    public function getUserById(int $id)
    {
        return User::find($id);
    }

    public function changePassword(String $password, User $user)
    {
        $user->password = bcrypt($password);
        $user->save();
    }

    public function findResetPasswordUsers(string $email)
    {
        return DB::table("password_reset_tokens")->where('email', $email)->first();
    }

    public function deleteResetPasswordUser($user)
    {
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
    }

    public function createForgotPasswordToken(string $token, string $email)
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token
        ]);
    }

    public function findByResetToken(string $token)
    {
        return DB::table('password_reset_tokens')->where('token', $token)->first();
    }

    public function deleteAccount(int $userId)
    {
        DB::transaction(function () use ($userId) {

            User::where('id', $userId)->delete();
        });
    }
}
