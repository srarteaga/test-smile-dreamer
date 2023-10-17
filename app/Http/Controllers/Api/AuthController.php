<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;


class AuthController extends Controller
{
    /**
     * Register user function.
     *
     * @param  App\Http\Requests\User\RegisterRequest  $request
     * @return User
     */
    public function register(RegisterRequest $request) {

        DB::beginTransaction();
        try {

            $user           = new User;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            if(count($request->dreamers))
            {
                $user->dreamers()->createMany($request->dreamers);
            }
            DB::commit();
            return response($user, 201);

        } catch(\Exception $exception) {
            DB::rollback();
            return response()->json(['errors' => $exception->getMessage()], 500);
        }
        
    }

    /**
     * Login user function.
     *
     * @param  App\Http\Requests\User\LoginRequest  $request
     * @return user, token
     */
    public function login(LoginRequest $request) {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user  = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response(['user' => $user, 'token' => $token], 200);

        }   else {

            return response(['message' => 'Invalid credentials'], 403);
        }

    }
    /**
     * Get user login function.
     * @return user
     */
    public function user() {

       return response()->json(['user' => auth()->user()], 200);

    }

    /**
     * Loogout user function.
     * @return array
     */
    public function logout() {

        auth()->user()->tokens()->delete();
        return response(['messege' => 'Logged out'], 200);
    }

}
