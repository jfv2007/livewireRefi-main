<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin. de Equipos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{  auth()->user()->avatar_url }}" id="profileImage" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
         <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @can('user_index')
                <li class="nav-item">
                    <a href="{{ route('admin.categorias') }}"
                        class="nav-link {{ request()->is('admin/categorias') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-american-sign-language-interpreting"></i>
                        <p>
                            Categorias
                        </p>
                    </a>
                </li>
                @endcan

                @can('user_index')
                <li class="nav-item">
                    <a href="{{ route('admin.seccions') }}"
                        class="nav-link {{ request()->is('admin/seccions') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-assistive-listening-systems"></i>
                        <p>
                            Secciones
                        </p>
                    </a>
                </li>
                @endcan

                @can('user_index')
                <li class="nav-item">
                    <a href="{{ route('admin.plantas') }}"
                        class="nav-link {{ request()->is('admin/plantas') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-phone-volume"></i>
                        <p>
                            Plantas
                        </p>
                    </a>
                </li>
                @endcan


               {{--  @can('user_index')
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}"
                        class="nav-link {{ request()->is('admin/users') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                @endcan --}}

                {{-- Usuarios --}}
               @can('user_index')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->is('users') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuarios
                        </p>
                    </a>
                </li>
                @endcan

                @can('user_index')
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}"
                        class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                @endcan


               {{--  <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li> --}}
                {{-- permisos --}}
                @can('permission_index')
                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}"
                        class="nav-link {{ request()->is('permissions') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-radiation"></i>
                        <p>
                            Permissions
                        </p>
                    </a>
                </li>
                @endcan

                {{-- Role --}}
                @can('role_index')
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('roles') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-skull-crossbones"></i>
                        <p>
                            Role
                        </p>
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('admin.tag18s') }}"
                        class="nav-link {{ request()->is('admin/tag18s') ? 'active' : '' }}">
                        {{--  <a href="{{ route('admin.centros') }}" class="nav-link {{ request()->is('admin/centros') ? 'active': '' }}"> --}}
                        <i class="nav-icon fas fa-atom"></i>
                        <p>
                            Lista de Tags
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.fallas') }}"
                        class="nav-link {{ request()->is('admin/fallas') ? 'active' : '' }}">
                        {{--  <a href="{{ route('admin.centros') }}" class="nav-link {{ request()->is('admin/centros') ? 'active': '' }}"> --}}
                        <i class="nav-icon 	fas fa-charging-station"></i>
                        <p>
                            Falla de Tags
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.trabajos') }}"
                        class="nav-link {{ request()->is('admin.trabajos') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-industry"></i>
                        <p>
                            Trabajos de Tags
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    {{-- <form method="POST" action="{{ route('logout') }}"> --}}
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </form>
                </li>


                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
