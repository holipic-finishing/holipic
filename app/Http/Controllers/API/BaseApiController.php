<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    /**
	 * Response success
	 * @param  string  $message
	 * @param  array  $data
	 * @param  integer $status
	 * @return \Illuminate\Http\JsonResponse
	 */
    protected function responseSuccess($message = null, $data = null, $status = 200)
    {
        return \Response::json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Response error
     * @param  string  $message
     * @param  array  $errors
     * @param  integer $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseError($message = null, $errors = null, $status = 500)
    {
        return \Response::json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'data' => $errors
        ]);
    }

    /**
     * Response error
     * @param  string  $message
     * @param  array  $errors
     * @param  integer $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWithErrorCode($message = null, $errors = null, $code = 500)
    {
        return \Response::json([
            'message' => $message,
            'error' => $errors
        ], $code);
    }

    /**
     * Make response user data
     * @param  int $programId
     * @param  string $token
     * @param  boolean $isLogin
     * @return array
     */
    protected function makeResponseUserData($token = null, $isLogin = false)
    {
        $user = auth()->user();
        $data = [
            'user' => $user,
        ];

        if(!empty($token)){
            $data = array_merge($data, [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]);

            // Save user logged in
        }
        dd($data);
        
        return $data;
    }
}
