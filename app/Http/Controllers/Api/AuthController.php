<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;

        try {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth()->user();
                $token = $user->createToken('login_token')->accessToken;
                $data = [
                    'user' => new UserResource($user),
                    'token' => $token,

                ];
                return responseSuccess($data, 200, 'Login success!');
            } else {
                return responseError('Invalid email or password!', 500);
            }
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 500);
        }
    }

    public function signup(UserCreateRequest $request)
    {
        try {

            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $request->password,
                    'location' => $request->location,
                    'address' => $request->address
                ]); 

                $user->assignRole(User::USER);

                if ($request->profile_image) {
                    $user->addMedia($request->profile_image)->toMediaCollection('profile_image');
                }
                return $user;
            });
            if ($user) {
                return responseSuccess(new UserResource($user), 200, 'User Account Created Successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }
}