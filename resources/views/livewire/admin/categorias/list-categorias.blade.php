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
                                        <h4 class="card-title">Categorias Registradas</h4>
                                        <p class="card-category"></p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                @can('permission_create')
                                                    <button wire:click.prevent="addNewCategoria" class="btn btn-primary"><i
                                                            class="fa fa-plus-circle mr-1"></i> Agregar Categoria</button>
                                                @endcan
                                            </div>
                                        </div>



                                        <div class="table-responsive small">
                                            @if (count($categorias))
                                            <table class="table table-striped table-sm">
                                                <thead class="text-primary">
                                                    <th>ID</th>
                                                    <th>Descripcion</th>
                                                    <th class="text-right">Acciones</th>
                                                </thead>
                                                <tbody>
                                                    @forelse ($categorias as $categoria)
                                                        <tr>
                                                            <td>{{ $categoria->id }}</td>
                                                            <td>{{ $categoria->descripcion_c }}</td>

                                                            {{-- <td>{{ $permission->created_at }}</td>  --}}
                                                            <td class="td-actions text-right">

                                                                @can('permission_show')
                                                                    <a href=""
                                                                        wire:click.prevent="edit({{ $categoria }})"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Editar Categoria">
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
                                                                        wire:click.prevent="confirmCategoriaRemoval({{ $categoria->id }})">
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

                                            @if ($categorias->hasPages())
                                                <div class="card-footer">
                                                    <span class="mr-1">Registros</span>
                                                    {{ $categorias->total() }} . {{ $categorias->onEachSide(1)->links() }}
                                                    {{-- {{ $tag18s->onEachSide(1)->links('modals.livewire-pagination-links') }} --}}
                                                </div>
                                            @endif
                                            @else
                                                No existe ningun registro coincidente
                                            @endif

                                        </div>
                                    </div>
                                    <div class="card-footer mr-auto">
                                        {{-- {{ links($categorias) }} --}}
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
    <div class="modal fade"wire:ignore.self id="formcategoria" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateCategoria' : 'createCategoria' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Edit Categoria </span>
                            @else
                                <span>Agregar Nueva Categoria</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">




                        {{-- nombre_planta --}}
                        <div class="form-group">
                            <label for="descripcion_c">Descripcion Categoria</label>
                            <input type="text" style="text-transform:uppercase"
                                wire:model.defer="state.descripcion_c"
                                class="form-control @error('descripcion_c') is-invalid @enderror" id="descripcion_c"
                                aria-describedby="descripcion_cHelp" placeholder="Introducir Descripcion Categoria">
                            @error('descripcion_c')
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
                    <h5>Delete Categoria</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure want to delete this Categoria?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                            class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deleteCategoria" class="btn btn-danger"> <i
                            class="fa fa-trash mr-1"></i> Delete Categoria </button>
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
