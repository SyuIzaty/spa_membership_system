<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Customer;
use App\User;
use App\Staff;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if (in_array($user->role_id, ['SPA001', 'SPA002'])) {
                $staff = Staff::where('user_id', $user->id)->first();

                if ($staff && is_null($staff->staff_end_date)) {
                    Auth::login($user, $request->has('remember'));
                    return redirect('/list-booking')->with('user_id', $user->id);
                } else {
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['username' => 'Your account is inactive or expired.']);
                }
            }

            elseif ($user->role_id === 'SPA003') {
                Auth::login($user, $request->has('remember'));
                return redirect('/home')->with('user_id', $user->id);
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['username' => 'Unauthorized role.']);
            }
        }

        return redirect()->route('login')->withErrors(['username' => 'Incorrect username or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function registerSignup(Request $request)
    {
        $request->validate([
            'email'     => 'required|email|unique:customers,customer_email',
            'phone'     => 'required|string|max:15',
            'password'  => 'required|string|confirmed|min:8',
        ],[
            'email.unique' => 'This email is already registered.'
        ]);


        $userId = date('Y') . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2)) . rand(1000, 9999);

        $username = strstr($request->email, '@', true);

        try {
            $user = User::create([
                'id'        => $userId,
                'username'  => $username,
                'password'  => bcrypt($request->password),
                'role_id'   => 'SPA003',
            ]);

            Customer::create([
                'user_id'               => $userId,
                'customer_email'        => $request->email,
                'customer_phone'        => $request->phone,
                'customer_start_date'   => now(),
            ]);

            return redirect()->route('login')->with('success', 'Signup successful! You can now log in.');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function password()
    {
        return view('auth.password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:8|confirmed',
        ]);

        $email = $request->input('email');
        $username = strstr($email, '@', true);

        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with the given email address.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('login')->with('success', 'Password reset successfully. You can now log in with your new password.');
    }
}
