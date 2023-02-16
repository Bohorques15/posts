<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;

class PostsController extends Controller
{
    public function __construct(){
        View::share('menu_active', "Posts");
    }

    public function getIndex(){
        return view("admin.posts.list");
    }

    public function getList(){
        $user = User::getCurrent();

        if($user->hasRole('admin')){
            $posts = Post::all();
        }else{
            $posts = $user->posts()->get();
        }

        $posts_list=[];

        foreach($posts as $post){
            $posts_list[]=[
                $post->id,
                $post->title,
                $post->date,
                '<a class="btn btn-info btn-sm" href="'.route("admin_posts_edit",["post_id"=>$post->id]).'"><i class="fas fa-pencil-alt"></i> Editar</a>'.'<a class="btn btn-danger btn-sm" href="'.route("admin_posts_trash",["post_id"=>$post->id]).'"><i class="fas fa-trash"></i> Borrar</a>'
            ];
        }
        return response()->json(['data' => $posts_list]);
    }

    public function getCreate(){
    	return view("admin.posts.create");
    }

    public function create(Request $request){
        $data=$request->only(["title","content"]);

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'title' => 'required',
                'content' => 'required',
            ],[
                'title.required' => 'El titulo es requerido',
                'content.required' => 'El contenido es requerido',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $post= new Post();

        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->date = new \DateTime('now');

        $post->save();

        $user = User::getCurrent();

        $user->posts()->save($post);

        return redirect()->route("admin_posts")->with(["message_info"=>"Post creado exitosamente"]);
    }

    public function getEdit($post_id){
        $edit_post=Post::where("id",$post_id)->first();

        if(!$edit_post){
            return redirect()->route("admin_posts")->with(["message_info"=>"El post ".$post_id." no se encuentra registrado"]);
        }

        return view("admin.posts.edit",["post"=>$edit_post]);
    }

    public function getView($post_id){
        $edit_post=Post::where("id",$post_id)->first();

        $user = User::getCurrent();

        if(!$edit_post){
            return redirect()->route("dashboard")->with(["message_info"=>"El comentario ".$post_id." no se encuentra registrado"]);
        }

        return view("admin.posts.view",["post"=>$edit_post,"user"=>$user]);
    }

    public function update(Request $request){
        $data=$request->only(["title","content"]);

        $post_id=$request->get("post_id");

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'title' => 'required',
                'content' => 'required',
            ],[
                'title.required' => 'El titulo es requerido',
                'content.required' => 'El contenido es requerido',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $post = Post::where("id",$post_id)->first();

        $post->title = $data['title'];
        $post->content = $data['content'];

        $post->save();

        return redirect()->route('admin_posts')->with(["message_info"=>"Post actualizado exitosamente"]);
    }

    public function Trash($post_id){
        $post=Post::where("id",$post_id)->first();
        $message="Se ha eliminado el post: ".$post->title;
        
        Post::where("id",$post_id)->delete();

        return redirect()->route('admin_posts')->with(["message_info"=>$message]);
    }

}
