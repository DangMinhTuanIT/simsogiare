<?php

namespace App\Http\Controllers\Auth;

use App\Options;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Tip;
use App\Verify;
use App\PartnerServices;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required',
            'brandname' => 'required',
            'terms' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => '',
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        $preItem = $request->all();

        $cID = 1;
        $user = new User();
        $user->name = $preItem['name'];
        $user->email = $preItem['email'];
        $user->phone = $preItem['phone'];
        $user->address = $preItem['address'];
        $user->password = bcrypt($preItem['password']);
        $user->author = $cID;
        $user->editor = $cID;
        $user->type = config('simsogiare.user_type.partner');
        $user->status = config('simsogiare.status.inactive');
        $user->role_name = 'Đối tác';
        $user->save();

        $item = new Tip();
        $item->id = $user->id;
        $item->name = $preItem['name'];
        $item->brandname = $preItem['brandname'];
        $item->email = $preItem['email'];
        $item->phone = $preItem['phone'];
        $item->address = $preItem['address'];
        $item->location = $preItem['location'];
        if($preItem['website']) {
            $item->website = $preItem['website'];
            $verify_domain = true;
        }
        $item->author = $cID;
        $item->editor = $cID;
        $item->status = config('simsogiare.status.inactive');
        $result = $item->save();

        if ($result) {

            if(isset($preItem['services']) && $preItem['services']){
                foreach ($preItem['services'] as $sv) {
                    $sValid = PartnerServices::where(['partner_id' => $user->id, 'service_id' => $sv])->first();
                    if(!$sValid) {
                        $ps = new PartnerServices();
                        $ps->partner_id = $user->id;
                        $ps->service_id = $sv;
                        $ps->author = $cID;
                        $ps->editor = $cID;
                        if ($item->status == config('simsogiare.status.active')) {
                            $ps->status = config('simsogiare.verify_status.approved');
                        } else {
                            $ps->status = config('simsogiare.verify_status.pending');
                        }
                        $ps->save();
                    }
                }
            }

            //Add verify code
            $current = \Carbon\Carbon::now();
            $exprired_at = $current->addHours(24);

            $email_code = md5('email' . $user->id . uniqid());
            Verify::create([
                'type' => config('simsogiare.verify.email'),
                'code' => $email_code,
                'partner_id' => $user->id,
                'exprired_at' => $exprired_at,
            ]);
            Verify::create([
                'type' => config('simsogiare.verify.phone'),
                'code' => md5('phone' . $user->id . uniqid()),
                'partner_id' => $user->id,
                'exprired_at' => $exprired_at,
            ]);

            if(isset($verify_domain)) {
                Verify::create([
                    'type' => config('simsogiare.verify.domain'),
                    'code' => md5('domain' . $user->id . uniqid()),
                    'partner_id' => $user->id,
                    'exprired_at' => $exprired_at,
                ]);
            }

            event(new simsogiare((object)[
                'name' => $item->name,
                'module' => 'partner',
                'action' => config('simsogiare.actions.store'),
            ]));

            \App\myHelper::notify([
                'name' => '['. $item->name .'] đã đăng ký làm đối tác',
                'type' => config('simsogiare.notify_type.partner_new'),
                'url' => route('partner.info', $user->id),
            ]);

            $content = Options::getThankyou();
            if($content && $content->o_value){
                $content = $content->o_value;
            }else{
                $content = 'Chúng tôi sẽ xác thực thông tin tài khoản trước khi kích hoạt.';
            }

            \App\myHelper::sendThankYouEmail([
               'name'           =>  $preItem['name'],
               'partner_id'     =>  $user->id,
               'email'          =>  $preItem['email'],
               'code'           =>  $email_code,
            ]);

            return view('systems.thankyou', array('content' => $content));
        }
        return redirect()->route('register')->with('error', 'Đăng ký không thành công. Vui lòng thử lại hoặc liên hệ với quản trị viên');
    }

}
