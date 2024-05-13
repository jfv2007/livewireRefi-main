<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/color-modes.js' ])
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href=" {{ asset('backend/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    {{-- Material Design specs. --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .custom-error .select2-selection {
            border: none;
        }
    </style>

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">


    @stack('styles')
    <livewire:styles />
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.partials.aside')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{ $slot }}
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('layouts.partials.footer')

        <main class="py-4">
            @yield('content')
        </main>
    </div>


    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <script type="text/javascript" src="https://unpkg.com/moment"></script>
    <script type="text/javascript"
        src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            toastr.options = {
                "positionClass": "toast-bottom-right",
                "progressBar": true,
            }

            window.addEventListener('hide-formtag', event => {
            $('#formtag').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formplanta', event => {
            $('#formplanta').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formcategoria', event => {
            $('#formcategoria').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formseccion', event => {
            $('#formseccion').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formfalla', event => {
            $('#formfalla').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formfallaedit', event => {
            $('#formfallaedit').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formfallaeditconsul', event => {
            $('#formfallaeditconsul').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formtrabajoedit', event => {
            $('#formtrabajoedit').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })
        /* cerra modal de editar consulta de trabajo */
        window.addEventListener('hide-formtrabajoeditconsulta', event => {
            $('#formtrabajoeditconsulta').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formtrabajoAdd', event => {
            $('#formtrabajoAdd').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-formtrabajoAgregar', event => {
            $('#formtrabajoAgregar').modal('hide'); /* cerrar modal de tags */
            toastr.success(event.detail.message, 'Success!');
        })





/*
            window.addEventListener('hide-form', event => {
                $('#form').modal('hide');
                toastr.success(event.detail.message, 'Success!');
            }) */
        });
    </script>

    <script>

        window.addEventListener('show-formtag', event => {
            $('#formtag').modal('show');
        })

        window.addEventListener('show-formplanta', event => {
            $('#formplanta').modal('show');
        })

        window.addEventListener('show-formcategoria', event => {
            $('#formcategoria').modal('show');
        })

        window.addEventListener('show-formseccion', event => {
            $('#formseccion').modal('show');
        })

        window.addEventListener('show-formfalla', event => {
            $('#formfalla').modal('show');
        })

        window.addEventListener('show-formHistorial', event => {
            $('#formHistorial').modal('show'); /* Muestra el historial */
        })

        window.addEventListener('show-delete-modal', event => {
            $('#confirmationModal').modal('show');
        })

        window.addEventListener('show-delete-modal-falla', event => {
            $('#confirmationModalFalla').modal('show');
        })

        window.addEventListener('show-delete-modal-trabajo', event => {
            $('#confirmationModalTrabajo').modal('show');
        })


        window.addEventListener('show-formfallaedit', event => {
            $('#formfallaedit').modal('show');
        })

        window.addEventListener('show-formfallaeditconsul', event => {
            $('#formfallaeditconsul').modal('show');
        })

        window.addEventListener('show-formtrabajoedit', event => {
            $('#formtrabajoedit').modal('show');
        })
        /* para el formulario de consulta es para editar  */
        window.addEventListener('show-formtrabajoeditconsulta', event => {
            $('#formtrabajoeditconsulta').modal('show');
        })

         window.addEventListener('show-formtrabajoAdd', event => {
            $('#formtrabajoAdd').modal('show');
         })

         window.addEventListener('show-formtrabajoAgregar', event => {
            $('#formtrabajoAgregar').modal('show');
         })

        window.addEventListener('show-form', event => {
            $('#form').modal('show');   /* mostrar modal Agregar user */
        })





        window.addEventListener('hide-delete-modal', event => {
            $('#confirmationModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-delete-modal-falla', event => {
            $('#confirmationModalFalla').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-delete-modal-trabajo', event => {
            $('#confirmationModalTrabajo').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('alert', event => {
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('updated', event => {
            toastr.success(event.detail.message, 'Success!');
        })
    </script>

     <script>

    </script>

   {{--  @stack('js')
    @yield('scrips') --}}
    <livewire:scripts />


    {{-- <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script> --}}
</body>
</html>
