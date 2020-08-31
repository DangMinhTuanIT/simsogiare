<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Session;

class LoginFacebookController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            if(auth()->user()->type == config('simsogiare.user_type.customer')){
				return redirect()->route('customer.package.info');
			}else{
				return redirect()->route('orders.list');
			}
        }
        return view('auth.login_facebook');
    }

    public function access_denied()
    {
        return view('auth.access_denied');
    }

    public function redirectToProvider($provider)
    {
        $fbConf = config('simsogiare.facebook');
        return Socialite::driver($provider)->scopes($fbConf['permission'])->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        if($user) {
            Session::put('fb_user_access_token', (string) $user->token);
            $authUser = User::where('provider_id', $user->id)->first();
            if ($authUser) {
                auth()->login($authUser, true);
				if($authUser->type == config('simsogiare.user_type.customer')){
					return redirect()->route('customer.package.info');
				}else{
					return redirect()->route('orders.list');
				}
            }else{
                $email = $user->id . '@facebook.com';
                $authUser = User::where('provider_id', $user->id)->first();
                if($authUser){
                    $authUser->provider_id = $user->id;
                    $authUser->save();
                    auth()->login($authUser, true);
					if($authUser->type == config('simsogiare.user_type.customer')){
						return redirect()->route('customer.package.info');
					}else{
						return redirect()->route('orders.list');
					}
                }else{
                    $_user = new User();
                    $_user->name = $user->name;
                    $_user->email = $email;
                    $_user->type = config('simsogiare.user_type.customer');
                    $_user->password = bcrypt('secret');
                    $_user->provider = $provider;
                    $_user->provider_id = $user->id;
                    $_user->status = config('simsogiare.status.active');
                    $_user->author = 1;
                    $_user->editor = 1;
                    $_user->save();

                    auth()->login($_user, true);
					return redirect()->route('customer.package.info');
                }
            }
        }
		
        return view('auth.login_facebook', array(
            'err' => 'Tài khoản đăng nhâp không hợp lệ.'
        ));
    }

    public function logout(){
        auth()->logout();
        return view('auth.login');
    }
}
