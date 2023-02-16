@extends('layouts.home')

@section('content')
  <div class="{{ session('page') }}-box">
    <div class="{{ session('page') }}-logo">
      <a href="../../index2.html"><b>Posts</b>Login</a>
    </div>
    <!-- /.login-logo -->
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
        <p class="{{ session('page') }}-box-msg">Introduzca sus datos</p>
        <form action="{{ route('login') }}" method="post">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Correo Electronico">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
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
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Iniciar sesion</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- /.social-auth-links -->
        <p class="mb-0">
          <a href="{{ route('register') }}" class="text-center">Registrarse</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
@endsection

