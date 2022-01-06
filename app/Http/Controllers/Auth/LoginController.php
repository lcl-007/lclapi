<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /**
     *登录
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized();
        }
        //检察用户状态
        $user = auth('api')->user();
        if ($user->is_locked == 1) {
            return $this->response->errorForbidden('被锁定了哦');
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     * 退出登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * 刷新token
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * 格式化返回
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60000
        ]);
    }

}
