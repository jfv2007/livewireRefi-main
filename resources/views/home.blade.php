<x-admin-layout>
    <div>
      <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Administracion de Equipos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             -  <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page 1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">Lista de Tags</h5>

                <p class="card-text">
                  1.-Administracion de los Tags Seleccionando->Centro de Trabajos->Planta-> Seleccionar Tag
                </p>

                {{-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> --}}
              </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">2.-Falla de Tag</h5>
                  </div>
                <div class="card-body">
                <h6 class="card-title"></h6>

                <p class="card-text">
                  Selecciona el icono de agregar falla, describiendo la anomalia del equipo y llenando los datos. Automaticamente el
                  Tag queda NO DISPONIBLE y la falla queda abierta PEND. POR ATENDER. Hasta que se genere el trabajo cambia
                  el STATUS De la falla a ATENDIDO.
                </p>
                {{-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> --}}
              </div>
            </div>   <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">3.- Trabajos del Tag</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title"></h6>

                <p class="card-text">Se agrega al tag cuando un trabajo de mantenimiento se le haga atendido
                    Primero se agrega el trabajo para tener un STATUS DE ATENDIDO, despues se busca el trabajo en la lista de trabajos
                    para colorar el STATUS FINAL, Si queda concluido el STATUS del tag queda DISPONIBLE. El Status del Tag cambia hasta
                    que el trabajo sea concluido por Mantto.
                </p>
                {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
              </div>
            </div>

            {{-- <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div> --}}
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>

  </x-admin-layout>
