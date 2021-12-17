<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
       public function __construct()
    {
        $this->middleware('auth:admin');
    }

 

    //
    public function index()
    {
        return view('admin.home');
    }





    public function logout()
    {
        Auth::logout();
        $data = [
            'message'    => 'Admin Logout Successfully !',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.login')->with($data);
    }
}
