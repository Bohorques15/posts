@extends('layouts.main')

@section('content')
  <section class="content">
    <div class="container-fluid">
      @if($errors->any())
        @foreach ($errors->all() as $error)
          <div class="callout callout-danger">
            <h4>Error!</h4>
            <p>{{$error}}.</p>
          </div>
        @endforeach
      @endif
      @if(session('message_info'))
        <div class="callout callout-info">
          <h4>Info</h4>
          <p>{{ session('message_info') }}</p>
        </div>
      @endif
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Post #{{ $post->id }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5>{{ $post->title }}</h5>
                <h6>De: {{ $post->user->name }} | {{ $post->user->email }}
                  <span class="mailbox-read-time float-right">{{ \Carbon\Carbon::parse($post->date)->format('d M y | g:i A') }}</span>
                </h6>
              </div>
              <!-- /.mailbox-read-info -->

              <div class="mailbox-read-message">
                {!! $post->content !!}
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-gray-light">
              @foreach($post->comments->sortByDesc('date') as $comment)
                <div class="mailbox-read-info">
                  <h6>{{ $comment->user->name }}
                    <div class="btn-group">
                      @if($user->hasRole('admin') || $user->comments->where('id',$comment->id)->count() > 0)
                        <a href="{{ route("admin_comments_trash",["comment_id"=>$comment->id]) }}" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Borrar">
                          <i class="far fa-trash-alt"></i>
                        </a>
                        <a href="{{ route("admin_comments_edit",["comment_id"=>$comment->id]) }}" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Editar">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                      @endif
                    </div>
                    <span class="mailbox-read-time float-right">{{ \Carbon\Carbon::parse($comment->date)->format('d M y | g:i A') }}</span>
                  </h6>
                  <div class="mailbox-read-message">
                    {!! $comment->content !!}
                  </div>
                </div>
              @endforeach
              <div class="input-group mb-3">
                <input type="text" class="form-control comment" name="comment" data-post="{{ $post->id }}" value="{{ old('comment') ? old('comment') : "" }}" placeholder="Agregue un nuevo comentario y presione enter">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-comment"></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
              @if($user->hasRole('admin') || $user->posts->where('id',$post->id)->count() > 0)
                <a href="{{ route("admin_posts_trash",["post_id"=>$post->id]) }}" class="btn btn-default"><i class="far fa-trash-alt"></i> Borrar</a>
                <a href="{{ route("admin_posts_edit",["post_id"=>$post->id]) }}" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Editar</a>
              @endif
              <div class="float-right">
                <a href="{{ route("dashboard") }}" class="btn btn-default"><i class="fas fa-angle-left right"></i> Regresar</a>
              </div>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <script>
    $(document).ready(function(){
      function AjaxRequest(form,url){
        var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
          beforeSend: function(request) {
            request.setRequestHeader("X-CSRF-TOKEN", CSRF_TOKEN);
          },
          /* the route pointing to the post function */
          url: url,
          type: 'POST',
          async: false,
          contentType: false,
          processData: false,
          /* send the csrf-token and the input to the controller */
          data: form,
          // dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function (data) {
            if (data.status == true) {
              location.reload();
            }
          },
          error: function (jqXHR, txtStatus, errorThrown) {
            console.log(jqXHR)
            console.log(txtStatus)
            console.log(errorThrown)
          }
        });
      }

      $('.comment').on('keypress', function (e) {
        if(e.which === 13){
          var form_data = new FormData();

          let content = $(this).val();

          let post = $(this).data('post');

          if(content != ""){
            form_data.append('content',content);
          }

          if(post != ""){
            form_data.append('post_id',post);
          }

          var ruta = "/admin/comments/create";

          AjaxRequest(form_data,ruta);
        }
      });

      // tooltip demo
      $('body').tooltip({
        selector: "[data-toggle=tooltip]"
      })
    });
  </script>
@endsection