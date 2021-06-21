<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cogs"></i>
                <span class="hidden-xs">{{ $user->nombre }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">

                <a href="{{ route('admin.perfil') }}" target="frameprincipal" class="dropdown-item">
                    <i class="fas fa-user"></i></i> Editar Perfil
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                    document.getElementById('frm-logout').submit();" class="dropdown-item"> <i class="fas fa-sign-out-alt"></i></i></i> Cerrar Sesión</a>

                <form id="frm-logout" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>

        <!-- maximizar la pantalla -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
