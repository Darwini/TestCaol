<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CAOL</title>
        <meta name="url" content="{{ url('/') }}">
        <meta name="token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
        <script type="text/javascript" src="{{ asset('/js/jquery-3.5.1.min.js') }}"></script>
        @yield('style')
    </head>
    
    <body class="antialiased" id="contenedor">
        <nav class="navbar navbar-expand-md bg-light navbar-light px-2 py-1">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.gif') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="fa fa-home"></i> Agence
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);">---</a>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="fa fa-list-alt"></i> Projectos
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);">---</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="fa fa-file-text-o"></i> Administrativo
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);">---</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" data-bs-toggle="dropdown">
                            <i class="fa fa-handshake-o"></i> Comercial
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('desempenho.index') }}">
                                Performance Comercial
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="fa fa-credit-card-alt"></i> Financeiro
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);">---</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="fa fa-user"></i> Usuario
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);">---</a>
                        </div>
                    </li>

                    <li class="nav-item" style="cursor: pointer;">
                        <a class="nav-link" name="logout">
                            <i class="fa fa-power-off"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('cabecera')
        
        @yield('contenido')
        <form id="logout" action="{{ route('logout') }}" method="POST"> @csrf </form>
        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/jquery-3.5.1.min.js') }}"></script>
        <script type="text/javascript">
            // var token = document.querySelectorAll('meta[name="csrf-token"]')[0].content;
            // var url = document.querySelectorAll('meta[name="url"]')[0].content;
            
            $(`[name="logout"]`).on('click', function(e){ $(`#logout`).submit(); });

            $(`[data-toggle="dropdown"]`).on('click', function(e){
                hideDropdown();
                $(this).next('.dropdown-menu').show();
            });

            $(`[data-toggle="tab"]`).on('click', function(e){
                $(`[data-toggle="tab"]`).not(this).removeClass('active');
                $(this).addClass('active');
                const target = $(this).attr('data-target');
                hideTab();
                $(`${target}`).show().addClass('show');
            });

            $(`[data-toggle="modal"]`).on('click', function(e){
                const target = $(this).attr('data-target');
                hideModal();
                $(`${target}`).show().addClass('show');
            });

            $(`[data-dismiss="modal"]`).on('click', function(e){ hideModal(); });

            function hideDropdown(){ $('.dropdown-menu').hide(); }

            function hideTab(){
                // $(`.tab-pane`).not(`${target}`).hide().removeClass('show');
                $(`.tab-pane`).hide().removeClass('show');
            }

            function hideModal(){ $('.modal').hide().removeClass('show'); }
        </script>
        @yield('js')
    </body>
</html>

