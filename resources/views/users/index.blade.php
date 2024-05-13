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
                          <h4 class="card-title"> Usuarios Registrados en la Base de datos  </h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success" role="success">
                              {{ session('success') }}
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-12 text-right">
                                    @can('user_create')
                                    <a href="{{ route('users.create') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Crear registro"> <i class="fa fa-plus-circle mr-1"> </i>Añadir usuario</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        {{-- <th>Username</th> --}}
                                        <th>Roles</th>

                                        <th class="text-right">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                             <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            {{-- <td>{{ $user->username }}</td> --}}
                                            <td>
                                                 @forelse ($user->roles as $role)
                                                    <span class="badge badge-info">{{ $role->name }}</span>
                                                @empty
                                                    <span class="badge badge-danger">No roles</span>
                                                @endforelse
                                                {{-- {{ $user->created_at }} --}}
                                            </td>
                                            <td class="td-actions text-right">
                                                @can('user_show')
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                                @endcan
                                                @can('user_edit')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                                <form action="{{ route('users.destroy',$user->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                                @endcan
                                                @can('user_destroy')
                                                 @csrf
                                                 @method('DELETE')
                                                <button class="btn btn-danger" type="submit" rel="tooltip">
                                                    <i class="material-icons">close</i>
                                                </button>
                                                @endcan
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                         </div>
                         <div class="card-footer mr-auto">
                            {{ $users->links() }}
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
