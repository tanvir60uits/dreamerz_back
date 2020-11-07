<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller{

    public  function login(Request $request){
		$user= User::where('email',$request->email)->first();
        if ($user){
            if ($user->status != 0){
                if (password_verify($request->password, $user->password)) {
                    $user->remember_token=$request->token;
                    $user->save();
                    $data['users']=$user;
                    $data['message']='success';
                }else{
                    $data['message']='error';
                }
            }else{
                $data['message']='error';
            }

        }else{
            $data['message']='error';
        }
        return $data;
    }

   public function registeration(Request $request){
        $users= User::where('email',$request->email)->first();

        $securitypin = rand(1111, 9999);
        $user= New User();
        $user->name=$request->name;
        $user->role=2;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->password=bcrypt($request->password);
        $user->securitypin=$securitypin;
        if(!empty($request->type)){
            $user->remember_token=$request->token;
        }
        
        if ($users == null){
            
            $user->save();
        }

        if(empty($request->type)){
            Mail::send('emails.verifiaction',['target'=>$user], function ($message)use($user) {
                $message->from(env('MAIL_FROM_ADDRESS'), 'Assignment');
                $message->to($user->email);
                $message->subject('Email Verification');
            });
        }

        $data['users']=$users == null? $user : $users;
        $data['message']='success';

        return $data;
    }
    
    
    
    public function email_verify_code(Request $request){
        $user= User::where('securitypin',$request->securitypin)->first();
       
        if ($user->securitypin == $request->securitypin){
            $user->status=1;
            $user->save();
            $data['message']='success';
        }else{
            $data['message']='error';
        }
        return $data;
    }

    public function email_check(Request $request){
        $user= User::where('email',$request->email)->first();
        if ($user != null){
            $securitypin = rand(1111, 9999);
            $user->securitypin=$securitypin;
            $user->save();
            Mail::send('emails.verifiaction',['target'=>$user], function ($message)use($user) {
                $message->from(env('MAIL_FROM_ADDRESS'), 'Assignment');
                $message->to($user->email);
                $message->subject('Email Verification');
            });
            $data['users']=$user;
            $data['message']='success';
        }else{
            $data['message']='error';
        }
        return $data;
    }

    public function password_verify_code(Request $request){
        $user= User::where('securitypin',$request->securitypin)->where('remember_token',$request->token)->first();
        if ($user->securitypin == $request->securitypin){
            $data['users']=$user;
            $data['message']='success';
        }else{
            $data['message']='error';
        }
        return $data;
    }

    public function change_password(Request $request){
        $user= User::where('remember_token',$request->token)->first();
        if ($user !=null){
            $user->password=bcrypt($request->password);
            $user->save();
            $data['message']='success';
        }else{
            $data['message']='error';
        }
        return $data;
    }
}
