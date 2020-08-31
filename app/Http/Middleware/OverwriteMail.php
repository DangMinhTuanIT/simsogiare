<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;

use Closure;
use Illuminate\Support\Facades\Config;
use App;
use App\Options;

class OverwriteMail
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        /*
            $conf is an array containing the mail configuration, a described in
            config/mail.php. Something like

            [
                'driver' => 'smtp',
                'host' => 'smtp.mydomain.com',
                'port' => 'smtp.mydomain.com',
                'username' => foo',
                'password' => 'bar',
                'from' => [
                    'name'  => '',
                    'address'  => '',
                ],
                'encryption'    => '',
            ]
        */
        $items = Options::getSMTP();
        $conf = [];
        foreach ($items as $item){
            $k = str_replace('mail_','', $item->o_key);
            if($k == 'name' || $k == 'address'){
                $conf['from'][$k] = $item->o_value;
            }else{
                $conf[$k] = $item->o_value;
            }
        }

        if(!empty($conf)) {
            Config::set('mail', $conf);

            $app = \Illuminate\Support\Facades\App::getInstance();
            $app->register('Illuminate\Mail\MailServiceProvider');

            // create new mailer with new settings
//            $transport = (new \Swift_SmtpTransport($host, $port))
//                ->setUsername($username)
//                ->setPassword($password)
//                ->setEncryption($encryption);
//
//            \Mail::setSwiftMailer(new \Swift_Mailer($transport));

        }

        return $next($request);
    }
}