<div>
{{-- Este desplegado es de fallas principal --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-success" class="m-0">Lista de Fallas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tag18s</li> --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="row mb-3 p-2">

        {{-- Por año --}}
        <div class="col-md-1">
            <div wire:ignore>
                <label for="" class="text-warning">Por año</label>
                <select class="form-control" wire:model=porAno>
                    <option value=2022 class="p-3 mb-2 bg-success text-white">2022</option>
                    <option value=2023 class="p-3 mb-2 bg-success text-white">2023</option>
                    <option value=2024 class="p-3 mb-2 bg-success text-white">2024</option>
                    <option value=2025 class="p-3 mb-2 bg-success text-white">2025</option>
                </select>
            </div>
        </div>

        {{-- Por mes --}}
        <div class="col-md-1">
            <label for="" class="text-warning">Por Mes</label>
            <select class="form-control" wire:model=porAno>
                <option value=1 class="p-3 mb-2 bg-success text-white">ENERO</option>
                <option value=2 class="p-3 mb-2 bg-success text-white">FEBRERO</option>
                <option value=3 class="p-3 mb-2 bg-success text-white">MARZO</option>
                <option value=4 class="p-3 mb-2 bg-success text-white">ABRIL</option>
                <option value=5 class="p-3 mb-2 bg-success text-white">MAYO</option>
                <option value=6 class="p-3 mb-2 bg-success text-white">JUNIO</option>
                <option value=7 class="p-3 mb-2 bg-success text-white">JULIO</option>
                <option value=8 class="p-3 mb-2 bg-success text-white">AGOSTO</option>
                <option value=9 class="p-3 mb-2 bg-success text-white">SEPTIEMBRE</option>
                <option value=10 class="p-3 mb-2 bg-success text-white">OCTUBRE</option>
                <option value=11 class="p-3 mb-2 bg-success text-white">NOVIEMBRE</option>
                <option value=12 class="p-3 mb-2 bg-success text-white">DICIEMBRE</option>
            </select>
        </div>

        {{-- por centros --}}
        <div class="col-md-3">
            <div wire:ignore>
                <label for="" class="text-warning">Centros</label>
                <select wire:model="selectedCentro" id="id_centro" class="form-control select2">
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}" class="p-3 mb-2 bg-success text-white">
                            {{ $centro->nombre_centro }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Por planta --}}
        <div class=" col-md-3 p2">
            <div wire:ingone>
                @if ($selectedCentro != 0 && !is_null($selectedCentro))
                    <label for="planta" class="text-warning">Plantas</label>
                    <select wire:model="selectedPlanta"
                        class="form-control @error('selectedPlanta') is-invalid @enderror">
                        @foreach ($plantas as $planta)
                            <option value="{{ $planta->id }}" class="p-3 mb-2 bg-success text-white">
                                {{ $planta->nombre_planta }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div> {{-- "col-md-6" --}}

        {{-- Por categoria --}}
        <div class="col-md-2">
            @if ($selectedCentro != 0 && !is_null($selectedCentro))
                <label for="" class="text-warning">Categoria</label>
                <select wire:model="selectedCategoria" class="form-control">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" class="p-3 mb-2 bg-success text-white">
                            {{ $categoria->descripcion_c }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        {{-- Por Status --}}
        <div class="col-md-1">
            @if ($selectedCentro != 0 && !is_null($selectedCentro))
                <label for="" class="text-warning">Status</label>
                <select wire:model="selectedStatus" class="form-control">
                    <option value=3 class="p-3 mb-2 bg-success text-white">PEND. ATENDER</option>
                    <option value=4 class="p-3 mb-2 bg-success text-white">ATENDIDO</option>
                    {{--  @foreach ($status as $statu)
                        <option value="{{ $statu->id }}">{{ $statu->desc_status }}
                        </option>
                    @endforeach --}}
                </select>
            @endif
        </div>

        {{-- Paginacion --}}
        <div class="col-md-1">
            <label for="" class="text-warning">Por pagina</label>
            <select class="form-control" wire:model=perPage>
                <option value="5" class="p-3 mb-2 bg-success text-white">5</option>
                <option value="15" class="p-3 mb-2 bg-success text-white">15</option>
                <option value="25" class="p-3 mb-2 bg-success text-white">25</option>
            </select>
        </div>

        {{-- Por palabra para buscar --}}
        <div class="col-md-2">
            <label for="" class="text-warning">Search</label>
            <input type="text" style="text-transform:uppercase" class="form-control"
                wire:model.debounce.350ms="search">
        </div>


    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end mb-2">

                    </div>
                    <div class="card">
                        <div class="table-responsive small">
                            @if (count($fallas))
                            <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-info">#</th>
                                            <th scope="col" class="text-info"></th>
                                            <th scope="col" class="text-info">Tag</th>
                                            <th scope="col" class="text-info">Descripcion</th>
                                            <th scope="col" class="text-info">Descripcion falla</th>
                                            <th scope="col" class="text-info">Status</th>
                                            <th scope="col" class="text-info">Fecha</th>
                                            <th scope="col"class="text-info">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fallas as $falla)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    <img src="{{ $falla->foto_url }}" style="width: 50px;"
                                                        class="img img-circle mr-1" alt="">
                                                <td>{{ $falla->tagfallas->tag }}</td>
                                                </td>
                                                {{-- <td>{{$falla->tagfallas->id}}</td> --}}

                                                <td>{{ $falla->tagfallas->descripcion }}</td>
                                                <td>{{ $falla->descripcion_falla }}</td>
                                                <td>
                                                    @if ($falla->fllastatus->status_revison == 'PEND. ATENDER')
                                                        <span class="badge badge-primary">PEND. ATENDER</span>
                                                    @elseif($falla->fllastatus->status_revison)
                                                        <span class="badge badge-success">
                                                            {{ $falla->fllastatus->status_revison }}
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- <td>{{ $falla->fllastatus->status_revison }}</td>  --}}
                                                <td>{{ $falla->created_at }}</td>
                                                <td>


                                                    <a href="" data-toggle="tooltip" data-placement="top"
                                                        title="Editar Falla"
                                                        wire:click.prevent="edit({{ $falla }})">
                                                        <i class="fa fa-edit mr-2"></i>
                                                    </a>
                                                    <a href="" data-toggle="tooltip" data-placement="top"
                                                        title="Eliminar Falla"
                                                        wire:click.prevent="confirmFallaRemoval({{ $falla->id }})">
                                                        <i class="fa fa-trash text-danger mr-2"></i>
                                                    </a>
                                                        {{-- lo quite si es diferenten--}}
                                                     @if ($falla->fllastatus->status_revison == 'PEND. ATENDER')
                                                        <a href="" data-toggle="tooltip" data-placement="top"
                                                            title="Agregar Trabajo"
                                                            wire:click.prevent="addtrabajo({{ $falla }})">
                                                            <i class="fas fa-brush mr-2"></i>
                                                        </a>
                                                    @endif

                                                    {{-- SI TIENE TRABAJOS --}}
                                                     {{--   @if ($tag18->ttrabajo == 'FALSE')

                                                    @elseif($tag18->ttrabajo)
                                                        <a href="" data-toggle="tooltip" data-placement="top" title="Agregar Trabajo"
                                                        wire:click.prevent="agregartrabajo({{ $falla }})">
                                                        <i class="fas fa-brush mr-2"></i>
                                                        </a>
                                                    @endif --}}


                                                    {{-- @if ($falla->fllastatus->status_revison == 'ATENDIDO')
                                                        <a  href="{{ route('admin.tag18s.list-trabajos', $tag18) }}"  >
                                                            <i class="fas fa-address-book mr-2"></i>
                                                        </a>
                                                    @elseif($tag18->ttrabajo)
                                                    @endif --}}

                                                    {{-- SI TIENE TRABAJOS consultar trabajo --}}
                                                    {{--     @if ($falla->tagfallas->ttrabajo == 'TRUE') --}}

                                                            {{-- muestra el icono de consultar de trabajo --}}
                                                      @if ($falla->fllastatus->status_revison == 'ATENDIDO')
                                                        <a href="{{ route('admin.falla.list-consultas', $falla->id) }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Consultar Trabajo">
                                                            <i class="fas fa-address-book mr-2"></i>
                                                        </a>
                                                    @elseif($tag18->ttrabajo)
                                                    @endif

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($fallas->hasPages())
                                    <div class="card-footer">
                                        <span class="mr-1">Registros</span>
                                        {{ $fallas->total() }} . {{ $fallas->onEachSide(1)->links() }}

                                    </div>
                                @endif
                            @else
                                No existe ningun registro coincidente
                            @endif
                            {{-- <div class="card-footer">
                              {{ $tag18s->total() }}
                            </div> --}}
                        </div>
                        {{-- <div class="card-footer">
                            {{ links($tag18s) }}
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> {{-- content --}}


    <!-- Modal   y Editar-->
    <div class="modal fade"wire:ignore.self id="formfallaedit" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="editFallaModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span>Edit falla </span>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="invisible">
                            {{-- <div class="invisible"> --}}
                            <label for="id_tag18s">id de Tag</label>
                            <input type="text" wire:model.defer="id_tag18s"
                                class="form-control @error('id_tag18s') is-invalid @enderror" id="id_tag18s"
                                aria-describedby="id_tag18sHelp" placeholder="Id del Tag" readonly="readonly">
                            @error('id_tag18s')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tagnombre">Nombre de Tag</label>
                            <input type="text" wire:model.defer="tagnombre"
                                class="form-control @error('tagnombre') is-invalid @enderror" id="tagnombre"
                                aria-describedby="tagnombreHelp" placeholder="Id del Tag" readonly="readonly">
                            @error('tagnombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion de tag</label>
                            <input type="text" wire:model.defer="descripcion"
                                class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                aria-describedby="descripcionHelp" placeholder="Introducir descripcion"
                                readonly="readonly">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Descripcion de la Falla --}}
                        <div class="form-group">
                            <label for="descripcionfalla">Descripcion de Falla</label>
                            <textarea type="text" style="text-transform:uppercase" wire:model.defer="descripcionfalla"
                                class="form-control @error('descripcionfalla') is-invalid @enderror" id="descripcionfalla"
                                aria-describedby="descripcionfallaHelp" rows="3"></textarea>
                            @error('descripcionfalla')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        {{-- @livewire('admin.tag18.centro'); --}}

                        {{-- seleccionar el status --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            {{-- <div liwire:ignore> --}}
                            <label for="" class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="selectedStatusModal" id="id_status" class="form-control"
                                @error('selectedStatusModal') is-invalid @enderror>
                                <option value=></option>
                                <option value=4>ATENDIDO</option>
                                <option value=3>PEND. ATENDER</option>
                            </select>
                            @error('selectedStatusModal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            {{-- </div> --}}
                        </div> {{-- "col-md-6" --}}


                        {{-- escoger imagen --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="customFile">Escoger imagen </label>
                                @if ($foto_falla)
                                    <img src="{{ $foto_falla->temporaryUrl() }}" class="img img-circle d-block mb-2"
                                        style="width: 300px;" alt="">
                                @else
                                    {{--  <img src="https://cdn.pixabay.com/photo/2016/10/11/21/43/geometric-1732847_960_720.jpg" class="img img-circle d-block mb-2"
                                        style="width: 100px;" alt=""> --}}
                                    <img src="{{ $state['foto_url'] ?? '' }}" class="img img-circle d-block mb-2"
                                        style="width: 300px;" alt="">
                                @endif

                                {{-- aca es de la caja de texto --}}
                                <div class="custom-file">
                                    <input wire:model="foto_falla" type="file" class="custom-file-input"
                                        id="customFile">
                                    @error('foto_falla')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <label class="custom-file-label" for="customFile">
                                        @if ($foto_falla)
                                            {{ $foto_falla->getClientOriginalName() }}
                                        @else
                                            Choose Image
                                        @endif
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fa fa-times mr-1"></i> Cancel</button>
                        <button wire:click.prevent="updateFalla" class="btn btn-primary"><i
                                class="fa fa-save mr-1"></i>

                            <span>Guardar cambios</span>

                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> {{-- Modal --}}

    {{-- Modal --DELETE --}}
    <div class="modal fade" id="confirmationModalFalla" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Falla</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure want to delete this Fail?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                            class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deleteFalla" class="btn btn-danger"> <i
                            class="fa fa-trash mr-1"></i> Delete Falla </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal   y agreggar Trabajo z-->
    <div class="modal fade"wire:ignore.self id="formtrabajoAdd" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="showAddTrabajoModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span>Agregar Trabajo al Tag </span>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- ID Tag invisible --}}
                        <div class="form-group">
                            {{-- <div class="invisible"  > --}}
                            <label for="trabajo_id_tag18s">id de Tag para el trabajo</label>
                            <input type="text" wire:model.defer="trabajo_id_tag18s"
                                class="form-control @error('trabajo_id_tag18s') is-invalid @enderror"
                                id="trabajo_id_tag18s" aria-describedby="trabajo_id_tag18ssHelp"
                                placeholder="Id del Tag" readonly="readonly">
                            @error('trabajo_id_tag18s')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Nombre del Tag --}}
                        <div class="form-group">
                            <label for="tagnombre">Nombre de Tag</label>
                            <input type="text" wire:model.defer="tagnombre"
                                class="form-control @error('tagnombre') is-invalid @enderror" id="tagnombre"
                                aria-describedby="tagnombreHelp" placeholder="Nombre del tag" readonly="readonly">
                            @error('tagnombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Descripcion del Tag --}}
                        <div class="form-group">
                            <label for="descripcion">Descripcion de tag</label>
                            <input type="text" wire:model.defer="descripcion"
                                class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                aria-describedby="descripcionHelp" placeholder="Introducir descripcion"
                                readonly="readonly">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Descripcion de Trabajo --}}
                        <div class="form-group">
                            <label for="descripciontrabajo">Descripcion del Trabajo</label>
                            <textarea type="text" style="text-transform:uppercase" wire:model="descripciontrabajo"
                                class="form-control @error('descripciontrabajo') is-invalid @enderror"
                                id="descripciontrabajo" aria-describedby="descripciontrabajoHelp" rows="3"></textarea>
                            @error('descripciontrabajo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Status del trabajo --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="" class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model.defer="selectedStatusModalTrabajoAgregar" id="id_status"
                                    class="form-control @error('selectedStatusModalTrabajoAgregar') is-invalid @enderror">
                                    <option value="">Seleccionar el Status</option>
                                    {{-- @foreach ($status as $statu)
                                    <option value="{{ $statu->id }}">{{ $statu->status_trabajos }}
                                    </option>
                                @endforeach --}}
                                    <option value=5>PEND. ENTREGAR POR MANTTO</option>
                                    <option value=6>PEND. ENTREGAR POR C.I.A.</option>
                                    {{--   <option value = 4>ATENDIDO</option> --}}
                                </select>
                                @error('selectedStatusModalTrabajoAgregar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> {{-- "col-md-6" --}}

                        {{-- Escoger imagen --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="customFile">escoger imagen del Trabajo </label>
                                @if ($foto_trabajo)
                                    <img src="{{ $foto_trabajo->temporaryUrl() }}"
                                        class="img img-circle d-block mb-2" style="width: 400px;" alt="">
                                @else
                                    <img src="https://cdn.pixabay.com/photo/2016/10/11/21/43/geometric-1732847_960_720.jpg"
                                        class="img img-circle d-block mb-2" style="width: 400px;" alt="">
                                    {{-- <img src="{{ $state['foto_url'] ?? '' }}" class="img img-circle d-block mb-2"
                                    style="width: 200px;" alt=""> --}}
                                @endif

                                {{-- aca es de la caja de texto --}}
                                <div class="custom-file">
                                    <input wire:model="foto_trabajo" type="file" class="custom-file-input"
                                        id="customFile">
                                    @error('foto_trabajo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    {{-- <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                                </div> --}}
                                    <label class="custom-file-label" for="customFile">
                                        @if ($foto_trabajo)
                                            {{ $foto_trabajo->getClientOriginalName() }}
                                        @else
                                            Choose Image
                                        @endif
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fa fa-times mr-1"></i> Cancel</button>
                        <button wire:click.prevent="additemtrabajo" class="btn btn-primary"><i
                                class="fa fa-save mr-1"></i>

                            <span>Guardar cambios</span>

                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> {{-- Modal --}}

</div>
