<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\Session;
use Illuminate\Http\Request;
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

    public function username()
    {
        return 'username';
    }
    
    protected function credentials(Request $request)
    {
     

    //   if($admin->isAdmin == 0)
    //   {

    //     return ['username'=>'You have no admin access. Please contact your system administrator','isAdmin'=>'NO'] ;

    //   } else{         

    //     return ['username'=>$request->username,'password'=>$request->password,'isAdmin'=>1] ;

    //  }
    $admin = User::where('username',$request->username)->first();
    $checkUser = User::where('username',$request->username)->exists();

      if($checkUser)
      {
        if($admin->isAdmin == 0)
        {

          return ['username'=>'You have no admin access. Please contact your system administrator','isAdmin'=>'NO'] ;

        } else{         

          return ['username'=>$request->username,'password'=>$request->password,'isAdmin'=>1] ;

      }

      }else{

        return ['username'=>$request->username,'password'=>$request->password];

      }

    
      

        
    }

}

