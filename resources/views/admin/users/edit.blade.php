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
              <h3 class="card-title">Editar Usuario</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin_users_update')  }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="user_id" value="{{ old('user_id') ? old('user_id') : $user->id }}">
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
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" placeholder="Nombre completo">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>
                    </div>           
                  </div>
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input type="email" class="form-control" value="{{ old('email') ? old('email') : $user->email }}" name="email" placeholder="Correo electronico">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate') ? old('birthdate') : $user->birthdate }}" placeholder="Fecha de nacimiento">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-calendar"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="country" id="country" value="{{ old('country') ? old('country') : $user->country }}" placeholder="Pais">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-flag"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input type="password" class="form-control" name="password" value="{{ old('password') ? old('password') : "" }}" placeholder="Contraseña">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group mb-3">
                      <input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_password') ? old('confirm_password') : "" }}" placeholder="Confirmar contraseña">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin_users') }}" class="btn btn-danger">Regresar</a>
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
  <!-- jQuery UI -->
  <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.css') }}">
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function(){

      var availableCountries = [];

      function callback(data){
        data.forEach(function(element){
          availableCountries.push(element);
        });
      }

      var URL = "/admin/autocomplete";

      $.get(URL).done(callback).fail(function(jqXHR, txtStatus, errorThrown) {
        console.log(jqXHR);
        console.log(txtStatus);
        console.log(errorThrown);
      });

      $( "#country" ).autocomplete({
        source: availableCountries
      });

    });
  </script>
@endsection