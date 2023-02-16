@extends('layouts.main')

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Usuarios</h3>
            <div class="card-tools">
              <a class="btn btn-warning btn-sm" href="{{ route('admin_users_create') }} ">
                <i class="fas fa-plus"></i> Crear
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
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
              <table class="table table-striped projects" id="dataTables-users">
                <thead>
                  <tr>
                    <th style="width: 1%">
                      Nombre
                    </th>
                    <th style="width: 20%">
                      Fecha de nacimiento
                    </th>
                    <th style="width: 30%">
                      Pais
                    </th>
                    <th>
                      Correo
                    </th>
                    <th style="width: 8%" class="text-center">
                      Rol
                    </th>
                    <th style="width: 20%">
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
@endsection

@section('scripts')
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

  <!-- Page Scripts - Tables --> 
  <script>
    $(document).ready(function(){
      $('#dataTables-users').DataTable({
        ajax: '{{route("get_admin_users")}}',
          responsive: true,
          pageLength:10,
          sPaginationType: "full_numbers",
          responsive: true,
          oLanguage: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ usuarios",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando de _START_ a _END_ usuarios de un total de _TOTAL_",
            sInfoEmpty: "No se ha registrado ninguna usuario",
                sInfoFiltered: "(filtrado de un total de _MAX_ usuarios)",
                sSearch: "Buscar:",
                sLoadingRecords: "Cargando...",
              oPaginate: {
                  sFirst: "<<",
                  sPrevious: "<",
                  sNext: ">", 
                  sLast: ">>" 
              }
          }
      });             
                
      $(window).resize(function(){
        $('#dataTables-users').DataTable();
      });
    });
  </script>

@endsection