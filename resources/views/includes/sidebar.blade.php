<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Posts</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ ( isset($menu_active) && $menu_active == "Inicio" ) ? "active" : "" }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Inicio</p>
          </a>
        </li>
        @if(Auth::user()->getCurrentRol()->hasPermissionTo('create_posts') && Auth::user()->getCurrentRol()->hasPermissionTo('edit_posts') && Auth::user()->getCurrentRol()->hasPermissionTo('trash_posts'))
          <li class="nav-item">
            <a href="{{ route('admin_posts') }}" class="nav-link {{ ( isset($menu_active) && $menu_active == "Posts" ) ? "active" : "" }}">
              <i class="nav-icon fas fa-comment"></i>
              <p>Posts</p>
            </a>
          </li>
        @endif
        @if(Auth::user()->getCurrentRol()->hasPermissionTo('create_users') && Auth::user()->getCurrentRol()->hasPermissionTo('edit_users') && Auth::user()->getCurrentRol()->hasPermissionTo('trash_users'))
          <li class="nav-item">
            <a href="{{ route('admin_users') }}" class="nav-link {{ ( isset($menu_active) && $menu_active == "Usuarios" ) ? "active" : "" }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Usuarios</p>
            </a>
          </li>
        @endif
        @if(Auth::user()->getCurrentRol()->hasPermissionTo('create_comments') && Auth::user()->getCurrentRol()->hasPermissionTo('edit_comments') && Auth::user()->getCurrentRol()->hasPermissionTo('trash_comments'))
          <li class="nav-item">
            <a href="{{ route('admin_comments') }}" class="nav-link {{ ( isset($menu_active) && $menu_active == "Comentarios" ) ? "active" : "" }}">
              <i class="nav-icon fas fa-align-center"></i>
              <p>Comentarios</p>
            </a>
          </li>
        @endif
        <li class="nav-item">
          <a href="{{ route('admin_users_profile') }}" class="nav-link {{ ( isset($menu_active) && $menu_active == "Perfil" ) ? "active" : "" }}">
            <i class="nav-icon fas fa-user"></i>
            <p>Mi perfil</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>