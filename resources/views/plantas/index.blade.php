<x-admin-layout>
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
                            {{--  @can('permission_create') --}}
                              <a href="{{ route('plantas.create') }}" class="btn btn-primary">Añadir planta</a>
                             {{-- @endcan --}}
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div wire:ignore>
                                <label for="" class="text-warning" >Centros</label>
                                <select wire:model="selectedCentro" id="id_centro" class="form-control select2">
                                    @foreach ($centros as $centro)
                                        <option value="{{ $centro->id }}" class="p-3 mb-2 bg-primary text-white">{{ $centro->nombre_centro }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                          {{-- <div class="table-responsive">
                            <table class="table">
                              <thead class="text-primary">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Guard</th>
                                <th>Created_at</th>
                                <th class="text-right">Acciones</th>
                              </thead>
                              <tbody>
                                @forelse ($permissions as $permission)
                                <tr>
                                  <td>{{ $permission->id }}</td>
                                  <td>{{ $permission->name }}</td>
                                  <td>{{ $permission->guard_name }}</td>
                                  <td>{{ $permission->created_at }}</td>
                                   <td class="td-actions text-right">
                                     @can('permission_show')
                                    <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-info"><i
                                        class="material-icons">person</i></a>
                                     @endcan

                                     @can('permission_edit')
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning"><i
                                        class="material-icons">edit</i></a>
                                     @endcan
                                    @can('permission_destroy')
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                      style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                      @csrf
                                      @method('DELETE')
                                      <button class="btn btn-danger" type="submit" rel="tooltip">
                                        <i class="material-icons">close</i>
                                      </button>
                                    </form>
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
                          </div> --}}
                        </div>
                        <div class="card-footer mr-auto">
                        {{--   {{ $permissions->links() }} --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>

    </x-admin-layout>
