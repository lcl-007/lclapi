<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TestController extends BaseController
{
    public function index()
    {
        return User::all();
    }
   public function store(Request $request)
   {
    //    $validatedData = $request->validate([
    //        'title'=>'required|unique:posts|max:255',
    //        'body'=>'required',
    //    ]);
//生成器使用transforme
$user = User::all();
return  $this->response()->collection($user,new UserTransformer());
   }
public function users()
{   //獲取所有用戶信息
    // $users = User::all();
    // return $this->response()->collection($users,new UserTransformer);
    //token獲取用戶信息
    $user = auth('api')->user();
    return $user;
}
public function login()
{

    $credentials = request(['email', 'password']);

    if (!$token = auth('api')->attempt($credentials)) {

        return $this->response->errorUnauthorized();
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }



}
