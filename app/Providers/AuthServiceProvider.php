<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
    	$this->app['auth']->viaRequest('api', function ($request) {
    		if($request->header('User') && $request->header('Authorization')){
    			$user_header = $request->header('User');
                $token_header = $request->header('Authorization');
                if(strpos($token_header, 'Bearer ') !== false){
                    $token_header = str_replace('Bearer ', '', $token_header);
                }

    			$token_decrypted = openssl_decrypt($token_header, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));
    			$user_token = explode(':', $token_decrypted)[0];
    			$date_expires_token = explode(':', $token_decrypted)[1];

    			if($user_header == $user_token){
                    $user = new User();
                    $user->id = $user_token;
    			}else{
                    $user = null;
                }
    		}
            return $user;
    	});
    }
}
