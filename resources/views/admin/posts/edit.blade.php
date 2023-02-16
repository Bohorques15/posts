@extends('layouts.main')

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Actualizar Posts</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin_posts_update')  }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="post_id" value="{{ old('post_id') ? old('post_id') : $post->id }}">
              <div class="card-body">
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
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="title" value="{{ old('title') ? old('title') : $post->title }}" placeholder="Titulo">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-tag"></span>
                        </div>
                      </div>
                    </div>           
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label >Contenido</label>
                      <textarea class="form-control" id="compose-textarea" name="content" placeholder="Contenido" required rows="10" cols="80">{{ old('content') ? old('content') : $post->content }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin_posts') }}" class="btn btn-danger">Regresar</a>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!--/.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

@section('scripts')
  
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

  <script>
    $(document).ready(function(){
      //Add text editor
      $('#compose-textarea').summernote();
    });
  </script>
@endsection

