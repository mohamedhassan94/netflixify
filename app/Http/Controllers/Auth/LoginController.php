<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        config([

            'services.' . $provider . '.client_id' => setting($provider . '_client_id'),
            'services.' . $provider . '.client_secret' => setting($provider . '_client_secret'),
            'services.' . $provider . '.redirect_url' => setting($provider . '_redirect_url'),

            ]);

        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {

        try{

            // get the user's data on social media platform
            $social_user = Socialite::driver($provider)->user();

        }catch(Exception $e){

            // if error occurred .. redirect to home
            return redirect('/');

        };

        // look up the user's data in our database

        $user = User::where('provider', $provider)->where('provider_id', $social_user->getId())->first();

        if($user){

            // if the user exists in our database .. we confirm the login and redirect him to the requested page

            Auth::login($user, true);
            return redirect()->intended('/');

        }else{

            // if the user doesn't exist in our database .. we create an account for him

            $user = User::create([
                'name' => $social_user->getName(),
                'email' => $social_user->getEmail(),
                'provider' => $provider,
                'provider_id' => $social_user->getId(),
            ]);

            $user->attachRole('user');

            // then do the login and redirect the user to the requested page

            Auth::login($user, true);
            return redirect()->intended('/');

        }

    }
}
