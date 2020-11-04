<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(){

        $data['users']=User::all();
        return view('users.index',$data);
    }

    public function delete($id){
        User::where('id',$id)->delete();
        Session::flash('success','Successfully Delete');
        return redirect()->back();
    }
}
