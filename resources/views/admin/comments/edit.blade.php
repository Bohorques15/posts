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
              <h3 class="card-title">Actualizar Comentario</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin_comments_update')  }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="comment_id" value="{{ old('comment_id') ? old('comment_id') : $comment->id }}">
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
                    <div class="form-group">
                      <label >Contenido</label>
                      <textarea class="form-control" name="content" placeholder="Contenido" required rows="10" cols="80">{{ old('content') ? old('content') : $comment->content }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('dashboard') }}" class="btn btn-danger">Regresar</a>
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