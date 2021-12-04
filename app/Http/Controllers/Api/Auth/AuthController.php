<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\ApiBaseController;
use App\Http\Request\Api\Auth\LoginApiRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|object
     */
    public function login(LoginApiRequest $request)
    {
        $cred = collect($request)->only(['email', 'password'])->toArray();
        $user = User::with([])
            ->where('email', $request->input('email'))
            ->whereNotNull('password')
            ->first();

        if (!($token = $this->guard()->attempt($cred))) {
            return $this->failedResponse(['message' => 'Неверный пароль или email телефона']);
        }

        return [
            'token' => $token,
            'user' => ($user),
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return auth()->guard('api');
    }
}
