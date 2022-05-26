<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\MemberLoginResource;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {
        if (! $token = auth()->attempt($request->validated())) {

            return response()->json(
                [
                    'status' => 'error',
                    'error' => 'Email or password is incorrect, please try again',
                    'code' => JsonResponse::HTTP_UNAUTHORIZED,
                ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($token);
    }

    public function logout() {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Member successfully signed out',
            'code'  => JsonResponse::HTTP_OK,
        ], JsonResponse::HTTP_OK);
    }

    protected function createNewToken($token){

        return response()->json([
            'status' => 'success',
            'code' => JsonResponse::HTTP_OK,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => new MemberLoginResource(auth()->user()),
        ], JsonResponse::HTTP_OK);
    }

    public function changePassWord(ChangePassRequest $request, $memberId) {
        if ($memberId == auth()->user()->id) {
            $member = Member::where('id', $memberId)->update(
                ['password' => bcrypt($request->new_password)]
            );
            auth()->logout();

            return response()->json([
                'status' => 'success',
                'code' => JsonResponse::HTTP_CREATED,
                'message' => 'Member successfully changed password',
            ], JsonResponse::HTTP_CREATED);
        } else {

            return response()->json([
                'status' => 'error',
                'code' => JsonResponse::HTTP_UNAUTHORIZED,
                'error' => 'Unauthorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

    }
}
