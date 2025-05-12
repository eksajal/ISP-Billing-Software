<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth::id()){
            $usertype = Auth::user()->usertype;

            if($usertype == 'user'){
                return view('home.index');
            }
            elseif($usertype == 'admin'){
                return view('home.admin');
            }
        }
    }

    public function index(){
        return view('home.index');
    }


    public function payment_page(){
        return view('home.payment_page');
    }

    public function check_bill_page(){
        return view('home.check_bill_page');
    }


}
