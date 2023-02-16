<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\Country;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct(){
        View::share('menu_active', "Inicio");
    }

    public function getAdminDashboard(){
        $user = User::getCurrent();

        $posts = Post::orderBy('date', 'desc')->get();

    	return view('main.dashboard',["posts"=>$posts,"user"=>$user]);
    }

    public function Autocomplete(){

        $response = [];

        $status = false;

        $countries = Country::all();

		foreach ($countries as $country) {
			$response[] = $country->name;
		}

        $status = true;

        return response()->json($response);        
    }

}
