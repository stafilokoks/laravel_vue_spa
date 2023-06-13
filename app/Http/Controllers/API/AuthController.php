<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name'     => 'required',
                    'email'    => 'required|email|unique:users,email',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'validation error',
                        'errors'  => $validateUser->errors(),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $user = User::create(
                [
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make(
                        $request->password
                    ),
                ],
                Response::HTTP_CREATED
            );

            return response()->json(
                [
                    'status'   => true,
                    'message'  => 'User Created Successfully',
                    'token'    => $user->createToken(
                        "API_TOKEN"
                    )->plainTextToken,
                    'userName' => $user->name,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email'    => 'required',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'validation error',
                        'errors'  => $validateUser->errors(),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'Email & Password does not exist.',
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $user = User::where('email', $request->email)->first();

            return response()->json(
                [
                    'status'   => true,
                    'message'  => 'Logged In Successfully',
                    'token'    => $user->createToken(
                        "API_TOKEN"
                    )->plainTextToken,
                    'userName' => $user->name,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
