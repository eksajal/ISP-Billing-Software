<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function add_package_page(){
        return view('admin.add_package_page');
    }

    public function view_package_page(){
        return view('admin.view_package_page');
    }

    public function add_user_page(){
        return view('admin.add_user_page');
    }

    public function view_users_page(){
        return view('admin.view_users_page');
    }

    public function bill_history_page(){
        return view('admin.bill_history_page');
    }

}
