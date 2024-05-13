<div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-success" class="m-0">Lista de Trabajos</h1>
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
                    <option value=2022 class="p-3 mb-2 bg-info text-dark">2022</option>
                    <option value=2023 class="p-3 mb-2 bg-info text-dark">2023</option>
                    <option value=2024 class="p-3 mb-2 bg-info text-dark">2024</option>
                    <option value=2025 class="p-3 mb-2 bg-info text-dark">2025</option>
                </select>
            </div>
        </div>

        {{-- Por mes --}}
        <div class="col-md-1">
            <label for="" class="text-warning">Por Mes</label>
            <select class="form-control" wire:model=porAno>
                <option value=1 class="p-3 mb-2 bg-info text-dark">ENERO</option>
                <option value=2 class="p-3 mb-2 bg-info text-dark">FEBRERO</option>
                <option value=3 class="p-3 mb-2 bg-info text-dark">MARZO</option>
                <option value=4 class="p-3 mb-2 bg-info text-dark">ABRIL</option>
                <option value=5 class="p-3 mb-2 bg-info text-dark">MAYO</option>
                <option value=6 class="p-3 mb-2 bg-info text-dark">JUNIO</option>
                <option value=7 class="p-3 mb-2 bg-info text-dark">JULIO</option>
                <option value=8 class="p-3 mb-2 bg-info text-dark">AGOSTO</option>
                <option value=9 class="p-3 mb-2 bg-info text-dark">SEPTIEMBRE</option>
                <option value=10 class="p-3 mb-2 bg-info text-dark">OCTUBRE</option>
                <option value=11 class="p-3 mb-2 bg-info text-dark">NOVIEMBRE</option>
                <option value=12 class="p-3 mb-2 bg-info text-dark">DICIEMBRE</option>
            </select>
        </div>


        {{-- Por centros --}}
        <div class="col-md-3">
            <div wire:ignore>
                <label for="" class="text-warning">Centros</label>
                <select wire:model="selectedCentro" id="id_centro" class="form-control select2">
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}" class="p-3 mb-2 bg-info text-dark">
                            {{ $centro->nombre_centro }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Por plantas --}}
        <div class=" col-md-3 p2">
            <div wire:ingone>
                @if ($selectedCentro != 0 && !is_null($selectedCentro))
                    <label for="planta" class="text-warning">Plantas</label>
                    <select wire:model="selectedPlanta"
                        class="form-control @error('selectedPlanta') is-invalid @enderror">
                        @foreach ($plantas as $planta)
                            <option value="{{ $planta->id }}" class="p-3 mb-2 bg-info text-dark">
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
                        <option value="{{ $categoria->id }}" class="p-3 mb-2 bg-info text-dark">
                            {{ $categoria->descripcion_c }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        {{-- Por status --}}
        <div class="col-md-1">
            @if ($selectedCentro != 0 && !is_null($selectedCentro))
                <label for="" class="text-warning">Status</label>
                <select wire:model="selectedStatus" class="form-control">
                    <option value=4 class="p-3 mb-2 bg-info text-dark">ATENDIDO</option>
                    <option value=5 class="p-3 mb-2 bg-info text-dark">PEND. ENTREGAR MANTTO.</option>
                    <option value=6 class="p-3 mb-2 bg-info text-dark">PEND. ENTREGAR C.I.A.</option>
                    <option value=7 class="p-3 mb-2 bg-info text-dark">TERMINADO</option>
                    {{-- @foreach ($status as $statu)
                        <option value="{{ $statu->id }}">{{ $statu->desc_status }}
                        </option>
                    @endforeach --}}
                </select>
            @endif
        </div>

        {{-- por paginacion --}}
        <div class="col-md-1">
            <label for="" class="text-warning">Per Page</label>
            <select class="form-control" wire:model=perPage>
                <option value="5" class="p-3 mb-2 bg-info text-dark">5</option>
                <option value="15" class="p-3 mb-2 bg-info text-dark">15</option>
                <option value="25" class="p-3 mb-2 bg-info text-dark">25</option>
            </select>
        </div>

        {{-- Por busqueda --}}
        <div class="col-md-2">
            <label for="" class="text-warning">Search</label>
            <input type="text" style="text-transform:uppercase" class="form-control"
                wire:model.debounce.350ms="search">
        </div>

        {{-- <div class="content" wire:init="loadTags"> --}}
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-end mb-2">

                        </div>
                        <div class="card">
                            <div class="table-responsive small">
                                @if (count($trabajos))
                                <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-info">#</th>
                                                <th scope="col" class="text-info"></th>
                                                <th scope="col" class="text-info">Tag nombre</th>
                                                <th scope="col" class="text-info">Descripcion</th>
                                                <th scope="col" class="text-info">Descripcion falla</th>
                                                <th scope="col" class="text-info">Descripcion trabajo</th>
                                                <th scope="col" class="text-info">Status Trabajo</th>
                                                <th scope="col" class="text-info">Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trabajos as $trabajo)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>
                                                        <img src="{{ $trabajo->foto_url }}" style="width: 50px;"
                                                            class="img img-circle mr-1" alt="">


                                                    <td>{{ $trabajo->fallatrabajos->tagfallas->tag }}</td>
                                                    <td>{{ $trabajo->fallatrabajos->tagfallas->descripcion }}</td>
                                                    <td>{{ $trabajo->fallatrabajos->descripcion_falla }}</td>
                                                    <td>{{ $trabajo->des_trabajo }}</td>

                                                    <td>
                                                        @if ($trabajo->statustraba->status_trabajos == 'TERMINADO')
                                                            <span class="badge badge-primary">TERMINADO</span>
                                                        @elseif($trabajo->statustraba->status_trabajos)
                                                            <span class="badge badge-success">
                                                                {{ $trabajo->statustraba->status_trabajos }}
                                                            </span>
                                                        @endif
                                                    </td>


                                                    {{-- <td>{{ $trabajo->statustraba->status_trabajos }}</td> --}}

                                                    </td>

                                                    {{-- fallatrabajos
                                                        <td>{{ $falla->tagfallas->descripcion }}</td>
                                                    <td>{{ $falla->descripcion_falla }}</td>
                                                    <td>{{ $falla->fllastatus->status_revison }}</td>
                                                    <td>{{ $falla->created_at }}</td> --}}
                                                    <td>

                                                        {{-- @if ($trabajo->statustraba->status_trabajos == 'TERMINADO')
                                                        @else --}}
                                                            <a href="" data-toggle="tooltip"
                                                                data-placement="top" title="Editar Trabajo"
                                                                wire:click.prevent="edit({{ $trabajo }})">
                                                                <i class="fa fa-edit mr-2"></i>
                                                            </a>
                                                        {{-- @endif --}}
                                                    </td>
                                                    <td>
                                                        <a href="" data-toggle="tooltip" data-placement="top"
                                                            title="Eliminar Trabajo"
                                                            wire:click.prevent="confirmTrabajoRemoval({{ $trabajo->id }})">
                                                            <i class="fa fa-trash text-danger mr-2"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{-- SI TIENE FALLAS href="{{ route('admin.tag18s.list-fallas', $tag18) }}" --}}
                                                         @if ($trabajo->fallatrabajos->tagfallas->tfalla == 'TRUE')
                                                            <a href="{{ route('admin.trabajo.list-consultas', $trabajo->id) }}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Ver Falla de tag">
                                                                <i class="fas fa-toolbox mr-2"></i>
                                                            </a>
                                                        {{-- @elseif($tag18->tfalla) --}}
                                                        @endif
                                                    </td>

                                                </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($trabajos->hasPages())
                                        <div class="card-footer">
                                            <span class="mr-1">Registros</span>
                                            {{ $trabajos->total() }} . {{ $trabajos->onEachSide(1)->links() }}

                                        </div>
                                    @endif
                                @else
                                    No existe ningun registro coincidente
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div> {{-- content --}}



        <!-- Modal   y Editar-->
        <div class="modal fade"wire:ignore.self id="formtrabajoedit" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form autocomplete="off" wire:submit.prevent="editTrabajoModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <span>Editar Trabajo </span>
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="id_tag18s">id de falla</label>
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
                                <label for="descripcionfalla">Descripcion de Falla</label>
                                <textarea type="text" wire:model.defer="descripcionfalla"
                                    class="form-control @error('descripcionfalla') is-invalid @enderror"
                                    id="descripcionfalla" aria-describedby="descripcionfallaHelp"
                                    readonly="readonly" rows="3"></textarea>
                                @error('descripcionfalla')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="descripciontrabajo1">Descripcion de Trabajo</label>
                                 {{-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> --}}
                                <textarea type="text" style="text-transform:uppercase"
                                    wire:model.defer="descripciontrabajo1"
                                    class="form-control @error('descripciontrabajo1') is-invalid @enderror"
                                    id="descripciontrabajo1" aria-describedby="descripciontrabajo1Help" rows="3"></textarea>
                                @error('descripciontrabajo1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            {{-- @livewire('admin.tag18.centro'); --}}

                            <div class="col-span-6 sm:col-span-3 mt-3">
                                <div liwire:ignore>
                                    <label for=""
                                        class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model.defer="selectedStatusModal" id="id_status"
                                        class="form-control @error('selectedStatusModal') is-invalid @enderror">
                                        <option value="">Seleccionar el Status</option>
                                        <option value=5>PEND. ENTREGAR MANTTO.</option>
                                        <option value=6>PEND. ENTREGAR C.I.A.</option>
                                        <option value=7>TERMINADO</option>
                                        {{--  <option value="">Seleccionar el Status</option> --}}
                                        {{-- @foreach ($statusModals as $statusModal)
                                            <option value="{{ $statusModal->id }}">{{ $statusModal->desc_status }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                    @error('selectedStatusModal')
                                        <div class="invalid-feedback">
                                            {{ $mensaje }}
                                        </div>
                                    @enderror
                                </div>
                            </div> {{-- "col-md-6" --}}


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="customFile">escoger imagen </label>
                                    @if ($foto_trabajo)
                                        <img src="{{ $foto_trabajo->temporaryUrl() }}"
                                            class="img img-circle d-block mb-2" style="width: 400px;" alt="">
                                    @else
                                        {{--  <img src="https://cdn.pixabay.com/photo/2016/10/11/21/43/geometric-1732847_960_720.jpg" class="img img-circle d-block mb-2"
                                        style="width: 100px;" alt=""> --}}
                                        <img src="{{ $state['foto_url'] ?? '' }}" class="img img-circle d-block mb-2"
                                            style="width: 400px;" alt="">
                                    @endif

                                    {{-- aca es de la caja de texto --}}
                                    <div class="custom-file">
                                        <input wire:model="foto_trabajo" type="file" class="custom-file-input"
                                            id="customFile">
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
                            <button wire:click.prevent="updatetrabajo" class="btn btn-primary"><i
                                    class="fa fa-save mr-1"></i>

                                <span>Guardar cambios</span>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div> {{-- Modal --}}


        {{-- Modal --DELETE --}}
        <div class="modal fade" id="confirmationModalTrabajo" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Delete Trabajo</h5>
                    </div>

                    <div class="modal-body">
                        <h4>Are you sure want to delete this Fail?</h4>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                                class="fa fa-times mr-1"></i> Cancel</button>
                        <button type="button" wire:click.prevent="deleteTrabajo" class="btn btn-danger"> <i
                                class="fa fa-trash mr-1"></i> Delete Trabajo </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
