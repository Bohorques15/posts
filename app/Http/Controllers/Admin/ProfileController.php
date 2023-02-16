<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProfileController extends Controller
{
    public function getLogin(){
        $user = User::getCurrent();

        if($user){
            return redirect()->route('dashboard');
        }

        session(['page' => "login"]);

        return view('auth.login');
    }

    public function getRegister(){
        $user = User::getCurrent();

        if($user){
            return redirect()->route('dashboard');
        }

        session(['page' => "register"]);

        return view('auth.register');
    }

    public function postLogin(Request $request){
        $data = $request->only(['email','password']);
        $check_user = User::where("email",$data['email'])->first();

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], true)){
            return redirect()->route("dashboard");
        }

        if(!$check_user){
            return redirect()->back()->withErrors('El correo electrónico que has introducido no existe')->withInput($request->input());
        }else{
            return redirect()->back()->withErrors('La contraseña que has introducido es incorrecta')->withInput($request->input());
        }
    }

    public function postRegister(Request $request){
        $data=$request->only(["name","email","password","birthdate","country","confirm_password"]);

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'name' => 'required',
                'email' => 'required|email',
                'birthdate' => 'required',
                'country' => 'required',
                'password' => 'required',
                'confirm_password' => 'required',
            ],[
                'name.required' => 'El nombre es requerido',
                'birthdate.required' => 'La fecha es requerida',
                'country.required' => 'El pais es requerido',
                'email.required' => 'El correo es requerido',
                'email.email' => 'El campo correo debe tener un formato de correo electrónico',
                'password.required' => 'La contraseña es requerida',
                'confirm_password.required' => 'La confirmacion de contraseña es requerida',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $check_user=User::where("email",$data["email"])->first();
        if($check_user){
            return redirect()->back()->withErrors(["Ya existe un usuario registrado con ese correo electrónico"])->withInput($request->input());
        }

        $password=$request->get("password");
        if($password && !empty($password)){
            $confirm_password=$request->get("confirm_password");

            if($password!=$confirm_password){
                return redirect()->back()->withErrors(["Las contraseñas no coinciden"])->withInput($request->input());
            }

            if(strlen($password)<5){
                return redirect()->back()->withErrors(["La contraseña debe tener al menos 5 caracteres"])->withInput($request->input());
            }

            $data["password"]=Hash::make($data["password"]);
        }

        $user= new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->birthdate = $data['birthdate'];
        $user->country = $data['country'];

        $user->save();

        $user->assignRole('user');

        return redirect()->route("login")->with(["message_info"=>"Usuario creado exitosamente"]);
    }


    public function getDashboard(){
        $user = User::getCurrent();
        $rol = $user->getCurrentRol();

        if($rol){
            return redirect()->route("admin_dashboard");
        }
        Auth::logout();
        return redirect()->route('login')->withErrors(["No tiene un rol asignado"]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with(["message_info"=>"Sesión finalizada"]);
    }
}
