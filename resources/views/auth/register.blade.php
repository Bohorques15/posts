@extends('layouts.home')

@section('content')
  <div class="{{ session('page') }}-box">
    <div class="{{ session('page') }}-logo">
      <a href="{{ route('login') }}"><b>Posts</b>Registro</a>
    </div>

    <div class="card">
      <div class="card-body {{ session('page') }}-card-body">
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
        <p class="login-box-msg">Crear un nuevo usuario</p>
        <form action="{{ route('register')  }}" method="post">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="Nombre completo">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Correo electronico">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="date" class="form-control" name="birthdate" placeholder="Fecha de nacimiento">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-calendar"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="country" name="country" placeholder="Pais">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-flag"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="{{ route('login') }}" class="text-center">Ya estoy registrado</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->
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