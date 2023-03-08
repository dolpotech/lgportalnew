<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ApiResponse;


    /**
     * Login User
     *
     * @throws ValidationException
     */
    public function login(LoginUserRequest $request)
    {
        $user = User::with('roles')->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->type == 'local_government') {
            $designation = $user->local_government;
        } else if($user->type == 'ministry') {
            $designation = $user->ministry;
        }else{
            $designation = $user->ministry_office;
        }

        if ($designation->status == 0 || $user->status == 0)
        {
            return $this->sendApiSuccessResponse([], 'The provided credentials are inactive','');
        }
        $token = $user->createToken('auth')->plainTextToken;

        $slugs = array_map(function ($role) {
            return $role['slug'];
        }, $user->roles->toArray());

        return $this->sendApiSuccessResponse([
            'token' => $token,
            'user' => $user,
            'role_slugs' => $slugs,
            'designation' => $designation,
        ], 'Logged in successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return success('User successfully logged out');
    }
}
