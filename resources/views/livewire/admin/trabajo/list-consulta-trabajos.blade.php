<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lista de Trabajos del Tag </h1>
                    {{-- consulta los trabajos --}}
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


    {{-- CENTROS COMBO --}}
    <div class="row mb-3 p-2">
        <div class="col-md-3">
            <div wire:ignore>
                <label for="">Centros</label>
                <select wire:model="selectedCentroListFallas" id="id_centro" class="form-control select2">
                    @foreach ($centros as $centro)
                        <option value="{{ $centro->id }}">{{ $centro->nombre_centro }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- PLANTA COMBO --}}
        <div class=" col-md-3 p2">
            <div wire:ingone>
                @if ($selectedCentroListFallas != 0 && !is_null($selectedCentroListFallas))
                    <label for="planta">Plantas</label>
                    <select wire:model="selectedPlantaListFallas"
                        class="form-control @error('selectedPlanta') is-invalid @enderror">
                        @foreach ($plantas as $planta)
                            <option value="{{ $planta->id }}">{{ $planta->nombre_planta }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div> {{-- "col-md-6" --}}

        {{-- PLANTA COMBO --}}
        <div class="col-md-3 p2">
            <div wire:ingone>
                <label class="invisible" for="tag">Tag</label>
                <input class="invisible" type="text" style="text-transform:uppercase" wire:model.defer="tag"
                    class="form-control @error('tag') is-invalid @enderror" id="tag" aria-describedby="tagHelp"
                    placeholder="Introducir nombre del Tag">
                @error('tag')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div> {{-- "col-md-6" --}}
    </div>


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
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col">Tag</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Descripcion falla</th>
                                            <th scope="col">Descripcion trabajo</th>
                                            <th scope="col">Status Trabajo</th>
                                            <th scope="col">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trabajos as $trabajo)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    <img src="{{ $trabajo->foto_url }}" style="width: 50px;"
                                                        class="img img-circle mr-1" alt="">
                                                </td>

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
                                                {{-- fallatrabajos
                                                        <td>{{ $falla->tagfallas->descripcion }}</td>
                                                    <td>{{ $falla->descripcion_falla }}</td>
                                                    <td>{{ $falla->fllastatus->status_revison }}</td>
                                                    <td>{{ $falla->created_at }}</td> --}}
                                                <td>
                                                    <a href="" data-toggle="tooltip" data-placement="top"
                                                        title="Editar Trabajo"
                                                        wire:click.prevent="editconsulta({{ $trabajo }})">
                                                        <i class="fa fa-edit mr-2"></i>
                                                    </a>
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
                                                    {{-- @elseif($tag18->trabajo) --}}
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    <div class="modal fade"wire:ignore.self id="formtrabajoedit" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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


                        {{-- ID_ Tag --}}
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

                        {{-- Nombre del Tag --}}
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

                        {{-- Descripcion de Falla --}}
                        <div class="form-group">
                            <label for="descripcionfalla">Descripcion de Falla</label>
                            <textarea type="text" wire:model.defer="descripcionfalla"
                                class="form-control @error('descripcionfalla') is-invalid @enderror"
                                id="descripcionfalla" aria-describedby="descripcionfallaHelp" readonly="readonly" rows="3"></textarea>
                            @error('descripcionfalla')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Descripcion de la Trabajo --}}
                        <div class="form-group">
                            <label for="descripciontrabajo1">Descripcion de Trabajo</label>
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


                        {{-- SelectedStatusModal --}}
                        <div class="col-span-6 sm:col-span-3 mt-3">
                            <div liwire:ignore>
                                <label for="" class="block text-sm font-medium text-gray-700">Status</label>
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
