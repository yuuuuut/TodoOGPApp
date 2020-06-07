<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToTwitterProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterProviderCallback()
    {
        try {
            $providerUser = Socialite::driver('twitter')->user();
        } 
        catch (\Exception $e) {
            return redirect('/')->with('oauth_error', 'ログインに失敗しました');
        }
        $existUser = User::where('uid', $providerUser->getId())->first();
        if($existUser) {
            Auth::login($existUser);
            return redirect('/')->with('flash_message', 'ログイン済です');
        }

        $user = new User();
        $user->uid = $providerUser->getId();
        $user->name     = $providerUser->getName();
        $user->nickname = $providerUser->getNickname();
        $user->avatar   = $providerUser->getAvatar();
        $user->save();
        
        Auth::login($user);
        return redirect('/');
    }
    
    /**
     * ログアウト
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
