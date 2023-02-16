<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Validator;

class UsersController extends Controller
{
    public function __construct(){
        View::share('menu_active', "Usuarios");
    }

    public function getIndex(){
        return view("admin.users.list");
    }

    public function getList(){
        $users = User::all();
        $users_list=[];

        foreach($users as $user){

            $users_list[]=[
                $user->name,
                $user->birthdate,
                $user->country,
                $user->email,
                $user->getRoleNames()->first(),
                '<a class="btn btn-info btn-sm" href="'.route("admin_users_edit",["user_id"=>$user->id]).'"><i class="fas fa-pencil-alt"></i> Editar</a>'.'<a class="btn btn-danger btn-sm" href="'.route("admin_users_trash",["user_id"=>$user->id]).'"><i class="fas fa-trash"></i> Borrar</a>'
            ];
        }
        return response()->json(['data' => $users_list]);
    }

    public function getCreate(){
    	return view("admin.users.create");
    }

    public function create(Request $request){
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

        return redirect()->route("admin_users")->with(["message_info"=>"Usuario creado exitosamente"]);
    }

    public function getEdit($user_id){
        $edit_user=User::where("id",$user_id)->first();

        if(!$edit_user){
            return redirect()->route("admin_users")->with(["message_info"=>"El usuario ".$user_id." no se encuentra registrado"]);
        }

        return view("admin.users.edit",["user"=>$edit_user]);
    }

    public function getMyProfile(){
        $edit_user = User::getCurrent();

        View::share('menu_active', "Perfil");

        if(!$edit_user){
            return redirect()->back()->with(["message_info"=>"El usuario ".$user_id." no se encuentra registrado"]);
        }

        return view("admin.users.profile",["user"=>$edit_user]);
    }

    public function update(Request $request){
        $data=$request->only(["name","email","birthdate","country"]);

        $user_id=$request->get("user_id");

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'name' => 'required',
                'email' => 'required|email',
                'birthdate' => 'required',
                'country' => 'required',
            ],[
                'name.required' => 'El nombre es requerido',
                'birthdate.required' => 'La fecha es requerida',
                'country.required' => 'El pais es requerido',
                'email.required' => 'El correo es requerido',
                'email.email' => 'El campo correo debe tener un formato de correo electrónico',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $check_user=User::where("email",$data["email"])->first();
        if($check_user && $check_user->id!=$user_id){
            return redirect()->back()->withErrors(["Ya existe un usuario registrado con ese correo electrónico"])->withInput($request->input());
        }

        $user = User::where("id",$user_id)->first();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->birthdate = $data['birthdate'];
        $user->country = $data['country'];

        $password=$request->get("password");
        if($password && !empty($password)){
            $confirm_password=$request->get("confirm_password");

            if($password!=$confirm_password){
                return redirect()->back()->withErrors(["Las contraseñas no coinciden"])->withInput($request->input());
            }

            if(strlen($password)<5){
                return redirect()->back()->withErrors(["La contraseña debe tener al menos 5 caracteres"])->withInput($request->input());
            }

            $user->password = Hash::make($password);
        }

        $user->save();

        return redirect()->route("admin_users")->with(["message_info"=>"Usuario actualizado exitosamente"]);
    }

    public function updateProfile(Request $request){
        $data=$request->only(["name","email","birthdate","country"]);

        $user_id=$request->get("user_id");

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'name' => 'required',
                'email' => 'required|email',
                'birthdate' => 'required',
                'country' => 'required',
            ],[
                'name.required' => 'El nombre es requerido',
                'birthdate.required' => 'La fecha es requerida',
                'country.required' => 'El pais es requerido',
                'email.required' => 'El correo es requerido',
                'email.email' => 'El campo correo debe tener un formato de correo electrónico',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $check_user=User::where("email",$data["email"])->first();
        if($check_user && $check_user->id!=$user_id){
            return redirect()->back()->withErrors(["Ya existe un usuario registrado con ese correo electrónico"])->withInput($request->input());
        }

        $user = User::where("id",$user_id)->first();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->birthdate = $data['birthdate'];
        $user->country = $data['country'];

        $password=$request->get("password");
        if($password && !empty($password)){
            $confirm_password=$request->get("confirm_password");

            if($password!=$confirm_password){
                return redirect()->back()->withErrors(["Las contraseñas no coinciden"])->withInput($request->input());
            }

            if(strlen($password)<5){
                return redirect()->back()->withErrors(["La contraseña debe tener al menos 5 caracteres"])->withInput($request->input());
            }

            $user->password = Hash::make($password);
        }

        $user->save();

        return redirect()->route('admin_users_profile')->with(["message_info"=>"Perfil actualizado exitosamente"]);
    }


    public function Trash($user_id){
        $user=User::where("id",$user_id)->first();
        $message="Se ha eliminado el usuario: ".$user->email;
        
        User::where("id",$user_id)->delete();

        return redirect()->route("admin_users")->with(["message_info"=>$message]);
    }

}
