<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuth
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
            return response(array('error' => 1, 'message'=>'Vui lòng đăng nhập'), 200);
        }

        $token = base64_decode($token);

        $auth = explode(':', $token);

        if(is_array($auth)){

            $user = User::where(['email' => $auth[0]])->first();

            if($user){
                if(Hash::check($auth[1], $user->password)){
                    if($user->status == config('simsogiare.status.active')) {
                        $request->merge(array("user" => $user));
                    }else{
                        return response(array('error' => 1, 'message'=>'Tài khoản chưa được kích hoạt'), 200);
                    }
                }else{
                    return response(array('error' => 1, 'message'=>'Mã kết nối không đúng'), 200);
                }
            }else{
                return response(array('error' => 1, 'message'=>'Mã kết nối không đúng'), 200);
            }
        }else{
            return response(array('error' => 1, 'message'=>'Mã kết nối không hợp lệ'), 200);
        }

        return $next($request);
    }
}
