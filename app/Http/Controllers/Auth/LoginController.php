<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(\Illuminate\Http\Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $remember = $request->filled('remember');
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], $remember))
        {
            if (auth()->user()->status == 0) 
            {
                $this->logout($request);
                // Return them to the log in form.
                return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    // This is where we are providing the error message.
                    $this->username() => trans('auth.pending'),
                ]);
            } else if (auth()->user()->status == 2) 
            {
                $this->logout($request);
                // Return them to the log in form.
                return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    // This is where we are providing the error message.
                    $this->username() => trans('auth.reject'),
                ]);
            } else
            {
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        //Initialize value store.
        $emergency = ['Yes', 'No'];
        $detectionType = ['Information leakage', 'Infrastructure Exposure', 'Critical Vulnerabilities', 'DeepWeb / Darkweb monitoring', 'Identity monitoring', 'Cyber threats', 'Attacks on suppliers', 'Negative brand exposure', 'Analysis of malicious artifacts'];
        $detectionLevel = ['1- Committed Resilience', '2- Critical', '3- High', '4- Medium', '5- Information'];
        $tlp = ['TLP:RED', 'TLP:AMBER', 'TLP:GREEN', 'TLP:WHITE'];
        $pap = ['PAP:RED', 'PAP:AMBER', 'PAP:GREEN', 'PAP:WHITE'];
        $ioc = ['IP address (V4)', 'URI', 'URL', 'Email address', 'Email Subject', 'Host name', 'Domain name', 'MD5 Hash', 'SHA1 hash', 'SHA256 hash', 'SHA384 hash', 'SHA512 hash', 'Address', 'Asynchronous transfer mode address',
                'Autonomous System Number (ASN)', 'CIDR rule', 'CVE number', 'Archive', 'File path', 'IMPHASH', 'IP address (V6)', 'IPV4 Netmask', 'IPV4 Network', 'IPV6 Netmask', 'IPV6 Network',
                'MAC address', 'MUTEX name', 'Observable Composition', 'Organization Name', 'PEHASH', 'Phone number', 'Registration key', 'Serial Number', 'Top-level domain name', 'Unknown', 'Windows Executable File'];
        $cvss = ['0.0 (None)', '0.1 - 3.9 (Low)', '4.0 - 6.9 (Medium)', '7.0 - 8.9 (High)', '9.0 - 10.0 (Critical)'];
        $contactReason = ['Feedback', 'Report', 'Detection', 'Takedown', 'Financial', 'Commercial', 'Other'];
        $curLang = \App\Models\Lang::query()->where('user_id', $user->id)->get();
        $availLocale=['en'=>'en', 'pt'=>'pt'];

        //Session store.
        session()->put('emergency', $emergency);
        session()->put('dec_type', $detectionType);
        session()->put('dec_level', $detectionLevel);
        session()->put('tlp', $tlp);
        session()->put('pap', $pap);
        session()->put('ioc', $ioc);
        session()->put('cvss', $cvss);
        session()->put('contact_reason', $contactReason);
        session()->put('avail_locale', $contactReason);


        if(sizeof($curLang) > 0)
        {
            //Lang init setting
            session()->put('cur_lang', $curLang[0]->lang);
        } else
        {
            //Default lang en
            session()->put('cur_lang', 'en');
        }
    }
}
