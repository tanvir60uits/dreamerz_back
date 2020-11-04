<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){

        return view('login');
    }

    public function login_submit(Request $request){

        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);


        $customerCheck =User::where('email',$request->email)->first();
        if($customerCheck){
            if($customerCheck->role != 1){
                Session::flash('error', 'Opps! your are not Authorised');
                return redirect()->back();
            }else {
                if (password_verify($request->password, $customerCheck->password)) {
                    Auth::loginUsingId($customerCheck->id);
                    return redirect('dashboard');
                } else {
                    Session::flash('error', 'Opps! Invalid Credential');
                    return redirect()->back();
                }
            }
            }else{
            Session::flash('error', 'Opps! Invalid Credential');
            return redirect()->back();
        }


    }

    public function logout(){
        Auth::logout();
        return redirect('/');

    }
}
