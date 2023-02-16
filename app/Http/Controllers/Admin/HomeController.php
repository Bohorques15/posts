<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        $user = User::getCurrent();

        return redirect()->route('dashboard');

        if($user){
        	return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }
}
