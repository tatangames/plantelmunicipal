<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('images/logoalcaldia.png') }}" alt="Logo" class="brand-image img-circle elevation-3" >
        <span class="brand-text font-weight-light">Panel Web</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @can('grupo.bodega1.bodega')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-edit"></i>
                            <p>
                                Bodega
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ingreso.bodega1.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingreso</p>
                                    </a>
                                </li>
                            </ul>


                        @can('vista.grupo.bodega1.bodega.retiro')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('retiro.bodega1.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Retiro</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                    </li>
                @endcan

                @can('grupo.bodega1.proveedores')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-friends"></i>
                            <p>
                                Proveedores
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('vista.grupo.bodega1.proveedores.ingresar')
                                <li class="nav-item">
                                    <a href="{{ route('proveedor.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresar Proveedor</p>
                                    </a>
                                </li>
                            @endcan

                            @can('vista.grupo.bodega1.proveedores.listado')
                                <li class="nav-item">
                                    <a href="{{ route('proveedor.index.listado') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de Proveedores</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('grupo.bodega1.equipos')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>
                                Equipos
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        @can('vista.grupo.bodega1.equipos.registrar-material')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('registro.bodega1.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lista Materiales</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.equipos.bodega-numeracion')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('numeracion.bodega1.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bodega Numeración</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.equipos.lista-unidad-medida')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('unidad.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lista Unidad de Medida</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.equipos.lista-de-tipos')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('tipo.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lista de Tipos</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.equipos.lista-equipos')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('equipo.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lista de Equipos</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.equipos.lista-de-personas')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('persona.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lista de Personas</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                    </li>
                @endcan

                @can('grupo.bodega1.reportes')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-file"></i>
                            <p>
                                Reportes
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @can('vista.grupo.bodega1.reportes.reporte-ingreso')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('reporte.ingreso.bodega1') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte Ingreso</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.reportes.reporte-retiro')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('reporte.retiro.bodega1') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte Retiro</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                        @can('vista.grupo.bodega1.reportes.informe-de-bodega')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('informe.bodega1') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Informe de Bodega</p>
                                </a>
                            </li>
                        </ul>
                        @endcan

                    </li>
                @endcan


                @can('grupo.admin.roles-y-permisos')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-edit"></i>
                            <p>
                                Roles y Permisos
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permisos y Roles</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('grupo.bodega2.registros')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-edit"></i>
                            <p>
                                Registros
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('registro.bodega2.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin2.equipo.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Equipos</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('reporte.ingreso.bodega2') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reportes</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

            </ul>
        </nav>




    </div>
</aside>






