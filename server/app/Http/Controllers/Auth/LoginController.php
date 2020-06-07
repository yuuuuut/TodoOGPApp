<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use Auth;
use DB;

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
            return redirect('/')->with('flash_message', 'ログインに失敗しました');
        }
        $user = User::updateOrCreate(['uid' => $providerUser->getId()], [
            'name' => $providerUser->getName(),
            'nickname' => $providerUser->getNickname(),
            'avatar' => $providerUser->getAvatar(),
        ]);
        Auth::login($user);
        return redirect('/');
    }
    
    /**
     * ログアウト
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('flash_message', 'ログアウトしました');
    }
}
