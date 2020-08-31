<?php

namespace App\Http\Middleware;

use App\Options;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class APIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Token, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');

        $token = $request->header('Authorization');

        if(!$token){
            return response(array('error' => 1, 'message'=>'Không thể kết nối với máy chủ'), 200);
        }

        $sys_token = Options::getAPIToken();

        if(!$sys_token){
            return response(array('error' => 1, 'message'=>'S- Mã kết nối không hợp lệ'), 200);
        }

        if($token != $sys_token->o_value){
            return response(array('error' => 1, 'message' => 'C- Mã kết nối không hợp lệ'), 200);
        }

        return $next($request);
    }
}
