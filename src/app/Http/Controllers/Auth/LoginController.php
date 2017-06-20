<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectProvider($provider=null)
    {

        if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist

if($provider != 'twitter'){
    return Socialite::driver($provider)->setScopes(['email'])->redirect();
}else{
    return Socialite::driver($provider)->redirect();
}

//        return Socialite::driver($provider)->redirect();
    }


    public function handleCallback($provider=null)
    {
        $user = Socialite::driver($provider)->user();

        $localUser = User::where('email','=',$user->getEmail())->first();

        if(is_null($localUser)){
          $localUser = User::create([
                'email' => $user->getEmail(),
                'password' => bcrypt(''),
            ]);
        }

        Auth::login($localUser,true);


        if(is_null($localUser->perfil)){
            return redirect(route('profile'));
        }else{
            return redirect(route('feed'));
        }
    }
}
