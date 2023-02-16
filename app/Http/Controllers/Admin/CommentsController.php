<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Comment;
use App\Models\Post;
use App\User;
use App\Http\Controllers\Controller;
use Validator;

class CommentsController extends Controller
{
    public function __construct(){
        View::share('menu_active', "Comentarios");
    }

    public function getIndex(){
        return view("admin.comments.list");
    }

    public function getList(){

        $user = User::getCurrent();

        if($user->hasRole('admin')){
            $comments = Comment::all();
        }else{
            $comments = $user->comments()->get();
        }
        
        $comments_list=[];

        foreach($comments as $comment){
            $comments_list[]=[
                $comment->id,
                $comment->content,
                $comment->date,
                '<a class="btn btn-info btn-sm" href="'.route("admin_comments_edit",["comment_id"=>$comment->id]).'"><i class="fas fa-pencil-alt"></i> Editar</a>'.'<a class="btn btn-danger btn-sm" href="'.route("admin_comments_trash",["comment_id"=>$comment->id]).'"><i class="fas fa-trash"></i> Borrar</a>'
            ];
        }
        return response()->json(['data' => $comments_list]);
    }

    public function create(Request $request){
        $data=$request->only(["content","post_id"]);

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'content' => 'required',
            ],[
                'content.required' => 'El contenido es requerido',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['status'=>$status,"errors"=>$errors->all()]); 
        }

        $comment= new Comment();

        $comment->content = $data['content'];

        $comment->date = new \DateTime('now');

        $comment->save();

        $post = Post::find($data['post_id']);

        $user = User::getCurrent();

        $post->comments()->save($comment);

        $user->comments()->save($comment);

        $response = [];

        $status = true;

        $response['status'] = $status;

        return response()->json($response);
    }

    public function getEdit($comment_id){
        $edit_comment=Comment::where("id",$comment_id)->first();

        if(!$edit_comment){
            return redirect()->route("admin_comments")->with(["message_info"=>"El comentario ".$comment_id." no se encuentra registrado"]);
        }

        return view("admin.comments.edit",["comment"=>$edit_comment]);
    }

    public function update(Request $request){
        $data=$request->only(["content"]);

        $comment_id=$request->get("comment_id");

        $input_data = $request->all();

        $validator = Validator::make(
            $input_data, [
                'content' => 'required',
            ],[
                'content.required' => 'El contenido es requerido',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $comment = Comment::where("id",$comment_id)->first();

        $comment->content = $data['content'];

        $comment->save();

        return redirect()->route('admin_comments')->with(["message_info"=>"Comentario actualizado exitosamente"]);
    }

    public function Trash($comment_id){
        $comment=Comment::where("id",$comment_id)->first();
        $message="Se ha eliminado el comentario: ".$comment_id;
        
        Comment::where("id",$comment_id)->delete();

        return redirect()->route('admin_comments')->with(["message_info"=>$message]);
    }

}
