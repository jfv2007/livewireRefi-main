<div>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Plantas Registradas</h4>
                                        <p class="card-category"></p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                @can('permission_create')
                                                    <button wire:click.prevent="addNewPlanta" class="btn btn-primary"><i
                                                            class="fa fa-plus-circle mr-1"></i> Agregar Planta</button>
                                                @endcan
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div wire:ignore>
                                                <label for="" class="text-warning">Centros</label>
                                                <select wire:model="selectedCentro" id="id_centro"
                                                    class="form-control select2">
                                                    @foreach ($centros as $centro)
                                                        <option value="{{ $centro->id }}"
                                                            class="p-3 mb-2 bg-primary text-white">
                                                            {{ $centro->nombre_centro }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="table-responsive small">

                                            <table class="table table-striped table-sm">
                                                <thead class="text-primary">
                                                    <th>ID</th>
                                                    <th>planta_id</th>
                                                    <th>nombre planta</th>
                                                    <th class="text-right">Acciones</th>
                                                </thead>
                                                <tbody>
                                                    @forelse ($plantas as $planta)
                                                        <tr>
                                                            <td>{{ $planta->id }}</td>
                                                            <td>{{ $planta->planta_id }}</td>
                                                            <td>{{ $planta->nombre_planta }}</td>
                                                            {{-- <td>{{ $permission->created_at }}</td>  --}}
                                                            <td class="td-actions text-right">

                                                                @can('permission_show')
                                                                    <a href=""
                                                                        wire:click.prevent="edit({{ $planta }})"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Editar Plantas">
                                                                        <i class="fa fa-edit mr-2"></i>
                                                                    </a>
                                                                @endcan

                                                                {{-- @can('permission_edit') --}}
                                                                {{-- <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning"><i
                                        class="material-icons">edit</i></a> --}}
                                                                {{-- @endcan --}}
                                                                @can('permission_destroy')
                                                                    <a href="" data-toggle="tooltip"
                                                                        data-placement="top" title="Eliminar"
                                                                        wire:click.prevent="confirmPlantaRemoval({{ $planta->id }})">
                                                                        <i class="fa fa-trash text-danger mr-2"></i>
                                                                    </a>
                                                                    {{-- <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                      style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                      @csrf
                                      @method('DELETE')
                                      <button class="btn btn-danger" type="submit" rel="tooltip">
                                        <i class="material-icons">close</i>
                                      </button>
                                    </form> --}}
                                                                @endcan

                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2">Sin registros.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>


                                    </div>
                                    <div class="card-footer mr-auto">
                                        {{-- {{ $plantas->links() }} --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /.content -->
    <!-- Button trigger modal -->
    <!-- Modal  Agregar y Editar-->
    <div class="modal fade"wire:ignore.self id="formplanta" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updatePlanta' : 'createPlanta' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Edit Planta </span>
                            @else
                                <span>Agregar Nuevo Planta</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-span-6 sm:col-span-3">
                            <label for="centro" class="block text-sm font-medium text-gray-700">Centros</label>
                            <select select wire:model="selectedCentroModal" id="id_centromodal"
                                class="form-control @error('selectedCentroModal') is-invalid @enderror">
                                <option>--- Select a Centro ---</option>
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

                        {{-- planta_id --}}
                        <div class="form-group">
                            <label for="planta_id">Id planta</label>
                            <input type="text" style="text-transform:uppercase" wire:model.defer="state.planta_id"
                                class="form-control @error('planta_id') is-invalid @enderror" id="planta_id"
                                aria-describedby="planta_idHelp" placeholder=" Id de la planta">
                            @error('planta_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- nombre_planta --}}
                        <div class="form-group">
                            <label for="nombre_planta">Nombre de la planta</label>
                            <input type="text" style="text-transform:uppercase"
                                wire:model.defer="state.nombre_planta"
                                class="form-control @error('nombre_planta') is-invalid @enderror" id="nombre_planta"
                                aria-describedby="nombre_plantaHelp" placeholder="Introducir nombre de la planta">
                            @error('nombre_planta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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

    {{-- Modal --DELETE --}}

    <div class="modal fade" id="confirmationModal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Planta</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure want to delete this Planta?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                            class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deletePlanta" class="btn btn-danger"> <i
                            class="fa fa-trash mr-1"></i> Delete Planta </button>
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
