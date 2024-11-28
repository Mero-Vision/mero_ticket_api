<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function signup(UserCreateRequest $request){
        try{
            
            $user=DB::transaction(function()use($request){
                $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'password'=>$request->password,
                    'location'=>$request->location,
                    'address'=>$request->address
                ]);
                return $user;
            });
            if($user){
                return responseSuccess(new UserResource($user),200,'User Account Created Successfully!');
            }
        }
        catch(\Exception $e){
            return responseError($e->getMessage(),500);
        }
    }
}