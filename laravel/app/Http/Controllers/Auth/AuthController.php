<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /*
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function loginView()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * This function validate the data , if the data are not valid this function return to the login view with a message of errors ,
     * if the data are valid this function authenticate that the user data are in the DB , if the user data are in DB return to the home view.
     */
    public function login(Request $request)
    {
        $validator=Validator::make(Request::all(), array(
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ),
           array(
                'email.required'=>'El campo email es requerido',
                'password.required'=>'El campo password es requerido',
                'email.max'=>'El campo email no debe tener mas de 255 caracteres',
                'email.email'=>'El campo email debe de ser un correo electronico',
                'email.exists'=>'El email no existe en la base de datos'
           ));
        $errors=$validator->errors();
        if($validator->fails()){
            return view('auth.login')->withErrors($errors);
        }
        else{
            $log=Auth::attempt(['email' => $_POST['email'], 'password' => $_POST['password']]);
            if ($log) {
                return redirect('/home');
            }
            else{
                Session::flash('message-error','El email o password son incorrectos');
                return redirect('/auth/login');
            }


        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){
        return User::create($data);
    }

    private function lockoutTime()
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 60;
    }

    protected function maxLoginAttempts()
    {
        return property_exists($this, 'maxLoginAttempts') ? $this->maxLoginAttempts : 10;
    }


}
