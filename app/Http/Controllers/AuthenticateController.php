<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\User\RegisterService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    /**
     * Authenticate
     *
     * @param Request $request Request.
     *
     * @return JsonResponse
     */
    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();
        try {
            if (Auth::attempt($data)) {
                $user = Auth::user();
                return response()->success([
                    'user' => $user,
                    'access_token' => $user->createToken('')->plainTextToken,
                ]);
            }
            return response()->error([], trans('auth.failed'), 403);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * getProfile
     *
     * @param Request $request Request.
     *
     * @return JsonResponse
     */
    public function getProfile(Request $request)
    {
        try {
            return response()->success([
                'data' => Auth::user(),
            ]);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * Logout
     *
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();
            return response()->success();
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * Register
     *
     * @param RegisterRequest $request RegisterRequest.
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        try {
            $user = resolve(RegisterService::class)->handle($data);
            return response()->success([
                'data' => $user,
            ]);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }
}
