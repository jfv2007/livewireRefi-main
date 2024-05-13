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
                                        <h4 class="card-title">Secciones Registradas</h4>
                                        <p class="card-category"></p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                @can('permission_create')
                                                    <button wire:click.prevent="addNewSeccion" class="btn btn-primary"><i
                                                            class="fa fa-plus-circle mr-1"></i> Agregar Secciones</button>
                                                @endcan
                                            </div>
                                        </div>



                                        <div class="table-responsive small">
                                            @if (count($seccions))
                                            <table class="table table-striped table-sm">
                                                <thead class="text-primary">
                                                    <th>ID</th>
                                                    <th>Descripcion</th>
                                                    <th class="text-right">Acciones</th>
                                                </thead>
                                                <tbody>
                                                    @forelse ($seccions as $seccion)
                                                        <tr>
                                                            <td>{{ $seccion->id }}</td>
                                                            <td>{{ $seccion->descripcion_s }}</td>

                                                            {{-- <td>{{ $permission->created_at }}</td>  --}}
                                                            <td class="td-actions text-right">

                                                                @can('permission_show')
                                                                    <a href=""
                                                                        wire:click.prevent="edit({{ $seccion }})"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Editar Secciones">
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
                                                                        wire:click.prevent="confirmSeccionRemoval({{ $seccion->id }})">
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
                                            @if ($seccions->hasPages())
                                                <div class="card-footer">
                                                    <span class="mr-1">Registros</span>
                                                    {{ $seccions->total() }} .
                                                    {{ $seccions->onEachSide(1)->links() }}
                                                    {{-- {{ $tag18s->onEachSide(1)->links('modals.livewire-pagination-links') }} --}}
                                                </div>
                                            @endif
                                        @else
                                            No existe ningun registro coincidente
                                            @endif


                                        </div>

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
    <div class="modal fade"wire:ignore.self id="formseccion" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateSeccion' : 'createSeccion' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Edit Seccion </span>
                            @else
                                <span>Agregar Nueva Seccion</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        {{-- Seccion --}}
                        <div class="form-group">
                            <label for="descripcion_s">Descripcion Seccion</label>
                            <input type="text" style="text-transform:uppercase"
                                wire:model.defer="state.descripcion_s"
                                class="form-control @error('descripcion_s') is-invalid @enderror" id="descripcion_s"
                                aria-describedby="descripcion_sHelp" placeholder="Introducir Descripcion de la Seccion">
                            @error('descripcion_s')
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
    <div class="modal fade" id="confirmationModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Secciones</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure want to delete this Secciones?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                            class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deleteSeccion" class="btn btn-danger"> <i
                            class="fa fa-trash mr-1"></i> Delete Seccion </button>
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
