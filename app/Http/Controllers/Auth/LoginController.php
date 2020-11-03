<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
     public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function handleProviderCallback(Request $request, string $provider)
    {
        //Googleからユーザー情報を取得
        $providerUser = Socialite::driver($provider)->stateless()->user();
        
        //Googleのメールアドレスを元にユーザーモデルを取得
        $user = User::where('email', $providerUser->getEmail())->first();
        
        //Googleから取得したメールアドレスと同じメールアドレスを持つユーザーモデルが存在すれば、そのユーザーでログイン処理
        if ($user) {
            $this->guard()->login($user, true);
            return $this->sendLoginResponse($request);
        }
        
        return redirect()->route('register.{provider}', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $providerUser->token,
        ]);    
    }
}
