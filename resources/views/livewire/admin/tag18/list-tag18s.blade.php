<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-success" class="m-0">Lista de Tags</h1>
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
        {{-- combo Centro --}}
        <div class="col-md-3">
            <div wire:ignore>
                <label for="" class="text-warning">Centros</label>
                <select wire:model="selectedCentro" id="id_centro" class="form-control select2">
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}" class="p-3 mb-2 bg-primary text-white">
                            {{ $centro->nombre_centro }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- Select planta --}}
        <div class=" col-md-3 p2">
            <div wire:ingone>
                @if ($selectedCentro != 0 && !is_null($selectedCentro))
                    <label for="planta" class="text-warning">Plantas</label>
                    <select wire:model="selectedPlanta"
                        class="form-control @error('selectedPlanta') is-invalid @enderror">
                        @foreach ($plantas as $planta)
                            <option value="{{ $planta->id }}" class="p-3 mb-2 bg-primary text-white">
                                {{ $planta->nombre_planta }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div> {{-- "col-md-6" --}}
        {{-- combo categoria --}}
        <div class="col-md-2">
            @if ($selectedCentro != 0 && !is_null($selectedCentro))
                <label for=" "class="text-warning">Categoria</label>
                <select wire:model="selectedCategoria" class="form-control">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" class="p-3 mb-2 bg-primary text-white">
                            {{ $categoria->descripcion_c }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
        {{-- seleccion de centro --}}
        <div class="col-md-1">
            @if ($selectedCentro != 0 && !is_null($selectedCentro))
                <label for="" class="text-warning">Status</label>
                <select wire:model="selectedStatus" class="form-control">
                    @foreach ($status as $statu)
                        <option value="{{ $statu->id }}" class="p-3 mb-2 bg-primary text-white">
                            {{ $statu->desc_status }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
        {{-- por pagina --}}
        <div class="col-md-1">
            <label for="" class="text-warning">Per Page</label>
            <select class="form-control" wire:model=perPage>
                <option value="5" class="p-3 mb-2 bg-primary text-white">5</option>
                <option value="15" class="p-3 mb-2 bg-primary text-white">15</option>
                <option value="25" class="p-3 mb-2 bg-primary text-white">25</option>
            </select>
        </div>
        {{-- Etiqueta Search --}}
        <div class="col-md-2">
            <label for="" class="text-warning">Search</label>
            <input type="text" style="text-transform:uppercase" class="form-control"
                wire:model.debounce.350ms="search">
        </div>

        {{-- <div class="btn-group">

                <span class="mr-1">Registros</span>
                <span class="badge badge-pill badge-info"> {{ $tag18s->total() }}</span>

        </div> --}}

        {{-- <div class="col-md-1">
            <a wire:click="limpiar">
                <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i>Limpiar</button>
            </a>
        </div> --}}


    </div>

    {{-- <div class="content" wire:init="loadTags"> --}}
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end mb-2">
                        @can('permission_create')
                            <button wire:click.prevent="addNewTag" class="btn btn-primary"><i
                                    class="fa fa-plus-circle mr-1"></i> Add New Tag</button>
                        @endcan
                        {{--  <a href="{{ route('admin.tag18s.create') }}">
                            <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New
                                Tag</button>
                        </a> --}}
                    </div>

                    <div class="card">
                        <div class="table-responsive small">
                            @if (count($tag18s))
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-primary">#</th>
                                            <th scope="col" class="text-primary">imagen</th>
                                            <th scope="col" class="text-primary">Tag descr</th>
                                            <th scope="col" class="text-primary">Descripcion</th>
                                            <th scope="col" class="text-primary">Operacion</th>
                                            <th scope="col" class="text-primary">Ubicacion</th>
                                            <th scope="col" class="text-primary">Status</th>
                                            <th scope="col"class="text-primary">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tag18s as $tag18)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    <img src="{{ $tag18->foto_url }}" style="width: 50px;"
                                                        class="img img-circle mr-1" alt="">
                                                </td>
                                                <td>{{ $tag18->tag }}</td>
                                                <td>{{ $tag18->descripcion }}</td>
                                                <td>{{ $tag18->operacion }}</td>
                                                <td>{{ $tag18->ubicacion }}</td>
                                                <td>
                                                    @if ($tag18->tag18stags->desc_status == 'DISPONIBLE')
                                                        <span class="badge badge-primary">DISPONIBLE</span>
                                                    @elseif($tag18->tag18stags->desc_status)
                                                        <span class="badge badge-success">
                                                            {{ $tag18->tag18stags->desc_status }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <a href="" wire:click.prevent="confirmAppointmentRemoval({{ $appointment->id }})">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </a> --}}
                                                    @can('permission_destroy')
                                                        <a href="" wire:click.prevent="edit({{ $tag18 }})"
                                                            data-toggle="tooltip" data-placement="top" title="Editar Tag">
                                                            <i class="fa fa-edit mr-2"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('admin.tag18s.edit', $tag18) }}">
                                                        <i class="fa fa-edit mr-2"></i>
                                                    </a> --}}
                                                    {{-- ELIMINAR --}}
                                                    @can('permission_destroy')
                                                        <a href="" data-toggle="tooltip" data-placement="top"
                                                            title="Eliminar"
                                                            wire:click.prevent="confirmTagRemoval({{ $tag18->id }})">
                                                            <i class="fa fa-trash text-danger mr-2"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                                <td>
                                                    {{-- AGREGAR FALLA --}}
                                                    @if ($tag18->tag18stags->desc_status == 'DISPONIBLE'   )
                                                        <a href="" data-toggle="tooltip" data-placement="top"
                                                            title="Agregar Falla"
                                                            wire:click.prevent="addfalla({{ $tag18 }})">
                                                            <i class="fas fa-frown mr-2"></i>
                                                        </a>
                                                    @elseif($tag18->tag18stags->desc_status)
                                                    @endif
                                                </td>
                                                <td>

                                                    {{-- SI TIENE FALLAS --}}
                                                    @if ($tag18->tfalla == 'TRUE'AND $tag18->tag18stags->desc_status != 'DISPONIBLE')
                                                        <a href="{{ route('admin.tag18s.list-fallas', $tag18) }}"
                                                            data-toggle="tooltip" title="Ver descripcion Falla">
                                                            <i class="fas fa-toolbox mr-2"></i>
                                                        </a>
                                                    @elseif($tag18->tfalla)
                                                    @endif
                                                </td>
                                                <td>

                                                    {{-- SI TIENE TRABAJOS --}}
                                                    @if ($tag18->ttrabajo == 'TRUE' AND $tag18->tag18stags->desc_status != 'DISPONIBLE')
                                                        <a href="{{ route('admin.tag18s.list-trabajos', $tag18) }}"
                                                            data-toggle="tooltip" title="Ver descripcion trabajo">
                                                            <i class="fas fa-address-book mr-2"></i>
                                                        </a>
                                                    @elseif($tag18->ttrabajo)
                                                    @endif
                                                    {{--  <a href=""
                                                        wire:click.prevent="addfalla({{ $tag18 }})">
                                                        <i class="fas fa-frown mr-2"></i>
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($tag18s->hasPages())
                                    <div class="card-footer">
                                        <span class="mr-1">Registros</span>
                                        {{ $tag18s->total() }}. {{ $tag18s->onEachSide(1)->links() }}
                                        {{-- {{ $tag18s->onEachSide(1)->links('modals.livewire-pagination-links') }} --}}
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

    <x-confirmation-alert />

    <!-- /.content -->
    <!-- Button trigger modal -->
    <!-- Modal  Agregar y Editar-->
    <div class="modal fade " wire:ignore.self id="formtag" tabindex="-1" role="dialog" >
   {{--  <div class="modal fade"wire:ignore.self id="formtag" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateTag' : 'createTag' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Edit Tag </span>
                            @else
                                <span>Agregar Nuevo Tag</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{-- tag --}}
                        <div class="form-group">
                            <label for="tag">Tag</label>
                            <input type="text" style="text-transform:uppercase" wire:model="tag"
                                class="form-control @error('tag') is-invalid @enderror" id="tag"
                                aria-describedby="tagHelp" placeholder="Introducir nombre del Tag">
                            @error('tag')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- descripcion --}}
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                             {{-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> --}}
                            <textarea type="text" style="text-transform:uppercase" wire:model="descripcion"
                                class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                aria-describedby="descripcionHelp" placeholder="Introducir descripcion"  rows="3"></textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- operacion --}}
                        <div class="form-group">
                            <label for="operacion">Operacion</label>
                            <input type="text" style="text-transform:uppercase" wire:model="operacion"
                                class="form-control @error('operacion') is-invalid @enderror" id="operacion"
                                aria-describedby="operacionHelp" placeholder="Kg/cm2,  etc...">
                            @error('operacion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- ubicacion --}}
                        <div class="form-group">
                            <label for="ubicacion">Ubicacion</label>
                            <input type="text" style="text-transform:uppercase" wire:model="ubicacion"
                                class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion"
                                aria-describedby="ubicacionHelp" placeholder="Ubicacion en la planta">
                            @error('ubicacion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        {{-- @Seleccionar Centros --}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="centro" class="block text-sm font-medium text-gray-700">Centros</label>
                            <select select wire:model="selectedCentroModal" id="id_centromodal"
                                class="form-control @error('selectedCentroModal') is-invalid @enderror">
                                {{-- <option>--- Select a Centro ---</option> --}}
                                @foreach ($modalcentros as $modalcentro)
                                    <option value="{{ $modalcentro->id }}">{{ $modalcentro->nombre_centro }}</option>
                                @endforeach
                            </select>
                            @error('selectedCentroModal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        {{-- Seleccionar Planta --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="planta" class="block text-sm font-medium text-gray-700">Planta</label>
                                <select wire:model="selectedPlantaModal" id="state_id"
                                    class="form-control @error('selectedPlantaModal') is-invalid @enderror">
                                    {{-- @if (count($modalplantas) == 0) --}}
                                    {{-- <option>Seleccionar una planta</option> --}}
                                    {{-- @endif --}}
                                    <option value="" selected>Debe seleccionar un elemento</option>
                                    @foreach ($modalplantas as $modalplanta)
                                        <option value="{{ $modalplanta->id }}">{{ $modalplanta->nombre_planta }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedPlantaModal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- Seleccion --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            {{-- <div liwire:ignore> --}}
                            <label for="seccion" class="block text-sm font-medium text-gray-700">Seccion</label>
                            <select wire:model="selectedSeccionModal" id="id_seccion"
                                class="form-control @error('selectedSeccionModal') is-invalid @enderror">
                                <option value="">Seleccionar la seccion</option>
                                @foreach ($modalseccions as $modalseccion)
                                    <option value="{{ $modalseccion->id }}">
                                        {{ $modalseccion->descripcion_s }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedSeccionModal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            {{-- </div> --}}
                        </div> {{-- "col-md-6" --}}

                        {{-- Seleccionar Categoria --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="categoria"
                                    class="block text-sm font-medium text-gray-700">Categoria</label>
                                <select wire:model="selectedCategoriaModal" id="id_categoria"
                                    class="form-control @error('selectedCategoriaModal') is-invalid @enderror">
                                    <option value="">Seleccionar la categoria</option>
                                    @foreach ($modalcategorias as $modalcategoria)
                                        <option value="{{ $modalcategoria->id }}">
                                            {{ $modalcategoria->descripcion_c }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedCategoriaModal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> {{-- "col-md-6" --}}


                        {{-- seleccionar status --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="" class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model="selectedStatusModal" id="id_status"
                                    class="form-control @error('selectedStatusModal') is-invalid @enderror">
                                    <option value="">Seleccionar el Status</option>
                                    <option value=1>DISPONIBLE</option>
                                    <option value=2>NO DISPONIBLE</option>

                                    {{-- @foreach ($modalstatus as $modalstatu)
                <option value="{{ $modalstatu->id }}">{{ $modalstatu->desc_status }}
                </option>
            @endforeach --}}
                                </select>
                                @error('selectedStatusModal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> {{-- "col-md-6" --}}


                        {{-- escoger imagen --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="customFile">escoger imagen </label>
                                @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="img img-circle d-block mb-2"
                                        style="width: 400px;" alt="">
                                @else
                                    {{-- <img src="https://cdn.pixabay.com/photo/2016/10/11/21/43/geometric-1732847_960_720.jpg" class="img img-circle d-block mb-2"
                style="width: 100px;" alt=""> --}}
                                    <img src="{{ $state['foto_url'] ?? '' }}" class="img img-circle d-block mb-2"
                                        style="width: 400px;" alt="">
                                @endif
                                {{-- aca es de la caja de texto --}}
                                <div class="custom-file">
                                    <input wire:model="foto" type="file" class="custom-file-input"
                                        id="customFile">
                                    @error('foto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <label class="custom-file-label" for="customFile">
                                        @if ($foto)
                                            {{ $foto->getClientOriginalName() }}
                                        @else
                                            Choose Image
                                            {{--  {{ $foto->title }} --}}
                                        @endif
                                    </label>
                                </div>
                                {{-- @if ($photo)
        <img src="{{ $photo->temporaryUrl() }}"class="img d-block mt-2 w-100 rounded">
            @else
        <img src="{{ $state['avatar_url'] ?? '' }}" class="img d-block mb-2 w-100 rounded">
            @endif --}}
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fa fa-times mr-1"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i>
                            @if ($showEditModal)
                                <span>Guardar cambios</span>
                            @else
                                <span>Guardar</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> {{-- Modal --}}

    {{-- Modal Falla  --}}
    <div class="modal fade"wire:ignore.self id="formfalla" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="showFallaModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span>Agregar Falla al Tag</span>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="tag">Tag</label>
                            <input type="text" style="text-transform:uppercase" wire:model.defer="statefalla.tag"
                                class="form-control @error('tag') is-invalid @enderror" id="tag"
                                aria-describedby="tagHelp" placeholder="Introducir nombre del Tag"
                                readonly="readonly">
                            @error('tag')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" style="text-transform:uppercase"
                                wire:model.defer="statefalla.descripcion"
                                class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                aria-describedby="descripcionHelp" placeholder="Introducir descripcion"
                                readonly="readonly">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">

                            <label for="centro" class="block text-sm font-medium text-gray-700">Centros</label>
                            <select select wire:model="selectedCentroFalla" id="id_centromodal" readonly="readonly"
                                class="form-control @error('selectedCentroFalla') is-invalid @enderror">
                                <option>--- Select a Centro ---</option>
                                @foreach ($modalcentros as $modalcentro)
                                    <option value="{{ $modalcentro->id }}">{{ $modalcentro->nombre_centro }}</option>
                                @endforeach
                            </select>
                            @error('selectedCentroFalla')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="planta" class="block text-sm font-medium text-gray-700">Planta</label>
                                {{-- <select wire:model.defer="selectedPlantaModal" id="state_id" --}}
                                <select wire:model.defer="selectedPlantaFalla" id="state_id" readonly="readonly"
                                    class="form-control @error('selectedPlantaFalla') is-invalid @enderror">
                                    {{-- @if (count($modalplantas) == 0)
                                    <option>Seleccionar una planta</option>
                                @endif --}}
                                    @foreach ($fallaplantas as $fallaplanta)
                                        <option value="{{ $fallaplanta->id }}">{{ $fallaplanta->nombre_planta }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedPlantaFalla')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion de Falla del equipo</label>
                            <textarea type="text" style="text-transform:uppercase"
                                wire:model.defer="statefalla.descripcionfalla"
                                class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                aria-describedby="descripcionHelp" placeholder="Introducir descripcion" rows="3"></textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <label for="turno" class="block text-sm font-medium text-gray-700">Turno</label>
                            <select wire:model.defer="selectedTurnoFalla" id="state_id"
                                class="form-control @error('selectedTurnoFalla') is-invalid @enderror">
                                <option value="">Seleccionar el Turno</option>
                                <option value="1">TURNO 1</option>
                                <option value="2">TURNO 2</option>
                                <option value="2">TURNO 3</option>
                            </select>
                            @error('selectedTurnoFalla')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="" class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model.defer="selectedStatusFalla" id="id_status"
                                    class="form-control @error('selectedStatusFalla') is-invalid @enderror">
                                    {{-- <option value="">Seleccionar el Status falla</option> --}}
                                    <option value="PEND. ATENDER">PEND. ATENDER</option>
                                    {{-- @foreach ($fallastatus as $fallastatu)
                                        <option value="{{ $fallastatu->id }}">{{ $fallastatu->desc_status }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                @error('selectedStatusFalla')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> {{-- "col-md-6" --}}

                        {{-- imagen --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="customFile">Escoger imagen de falla </label>
                                @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="img img-circle d-block mb-2"
                                        style="width: 400px;" alt="">
                                @else
                                    <img src="https://cdn.pixabay.com/photo/2016/10/11/21/43/geometric-1732847_960_720.jpg"
                                        class="img img-circle d-block mb-2" style="width: 400px;" alt="">
                                @endif

                                {{-- aca es de la caja de texto --}}
                                <div class="custom-file">
                                    <input wire:model="foto" type="file" class="custom-file-input"
                                        id="customFile">

                                    <label class="custom-file-label" for="customFile">
                                        @if ($foto)
                                            {{ $foto->getClientOriginalName() }}
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
                        <button wire:click.prevent="createFalla" class="btn btn-primary"><i
                                class="fa fa-save mr-1"></i>
                            <span>Guardar cambios</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> {{-- Modal --}}

    {{-- Modal Historial --}}
    <div class="modal fade"wire:ignore.self id="formHistorial" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="showHistorialModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span>Historial del Tag</span>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="tag">Tag</label>
                            <input type="text" style="text-transform:uppercase" wire:model.defer="statefalla.tag"
                                class="form-control @error('tag') is-invalid @enderror" id="tag"
                                aria-describedby="tagHelp" placeholder="Introducir nombre del Tag"
                                readonly="readonly">
                            @error('tag')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" style="text-transform:uppercase"
                                wire:model.defer="statefalla.descripcion"
                                class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                                aria-describedby="descripcionHelp" placeholder="Introducir descripcion"
                                readonly="readonly">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="card">
                            <div class="card-body">
                                @if (count($tag18s))
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tag</th>
                                                <th scope="col">Descripcion</th>
                                                {{-- <th scope="col">operacion</th>
                                                <th scope="col">Ubicacion</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Options</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($fallas as $falla) --}}
                                            <tr>
                                                {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                                {{-- <td>
                                                <img src="{{ $falla->foto_url }}" style="width: 50px;"
                                                    class="img img-circle mr-1" alt="">
                                                    <td>{{ $falla->tagfallas->tag }}</td>
                                            </td> --}}


                                                {{-- <td>{{ $falla->descripcion_falla }}</td> --}}
                                                <td>
                                                    {{--  @if ($falla->fllastatus->status_revison == 'PEND. ATENDER')
                                                    <span class="badge badge-primary">PEND. ATENDER</span>
                                                @elseif($falla->fllastatus->status_revison)
                                                    <span class="badge badge-success">
                                                    {{ $falla->fllastatus->status_revison }}
                                                     </span>
                                                @endif --}}
                                                </td>
                                                {{-- <td>{{ $tag18->tag18Centro->nombre_centro }}</td> --}}

                                                {{-- DISPONIBLE --}}

                                            </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                    </table>
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


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fa fa-times mr-1"></i> Cancel</button>
                        <button wire:click.prevent="llamarHistorial" class="btn btn-primary"><i
                                class="fa fa-save mr-1"></i>
                            <span>Guardar cambios</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> {{-- Modal --}}

    {{-- Modal --DELETE --}}

    <div class="modal fade" id="confirmationModal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Tag</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure want to delete this Tag?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                            class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deleteTag" class="btn btn-danger"> <i
                            class="fa fa-trash mr-1"></i> Delete Tag </button>
                </div>
            </div>
        </div>
    </div>
</div> {{-- PRIMERO --}}

@push('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
</div>
