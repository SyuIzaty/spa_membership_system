<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\OauthIcomplaint;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class iComplaintGmailLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/iComplaint';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGmail()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGmailCallback()
    {
        try {
            // get user data from Google
            $user = Socialite::driver('google')->user();

            // find user in the database where the social id is the same with the id provided by Google
            // $finduser = User::where('id', $user->id)->first();

            $finduser = OauthIcomplaint::where('id', $user->id)->first();

            if ($finduser) {  // if user found then do this
                // Log the user in
                Auth::login($finduser);

                // redirect user to dashboard page
                $route = Crypt::encryptString($user->id);

                return redirect('/iComplaint-public/'.$route);
            } else {
                // if user not found then this is the first time he/she try to login with Google account
                // create user data with their Google account data
                $newUser = OauthIcomplaint::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                ]);

                Auth::login($newUser);

                $route = Crypt::encryptString($user->id);

                return redirect('/iComplaint-public/'.$route);
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


}
