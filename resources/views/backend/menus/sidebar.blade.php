<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
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

                        <ul class="nav nav-treeview">
                            @can('vista.grupo.bodega1.equipos.registrar-material')

                                    <li class="nav-item">
                                        <a href="{{ route('registro.bodega1.index') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lista Materiales</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.equipos.bodega-numeracion')

                                    <li class="nav-item">
                                        <a href="{{ route('numeracion.bodega1.index') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bodega Numeración</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.equipos.lista-unidad-medida')

                                    <li class="nav-item">
                                        <a href="{{ route('unidad.index') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lista Unidad de Medida</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.equipos.lista-de-tipos')

                                    <li class="nav-item">
                                        <a href="{{ route('tipo.index') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lista de Tipos</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.equipos.lista-equipos')

                                    <li class="nav-item">
                                        <a href="{{ route('equipo.index') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lista de Equipos</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.equipos.lista-de-personas')

                                    <li class="nav-item">
                                        <a href="{{ route('persona.index') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lista de Personas</p>
                                        </a>
                                    </li>

                            @endcan
                        </ul>
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

                        <ul class="nav nav-treeview">
                            @can('vista.grupo.bodega1.reportes.reporte-ingreso')

                                    <li class="nav-item">
                                        <a href="{{ route('reporte.ingreso.bodega1') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reporte Ingreso</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.reportes.reporte-retiro')

                                    <li class="nav-item">
                                        <a href="{{ route('reporte.retiro.bodega1') }}" target="frameprincipal" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reporte Retiro</p>
                                        </a>
                                    </li>

                            @endcan

                            @can('vista.grupo.bodega1.reportes.informe-de-bodega')

                                <li class="nav-item">
                                    <a href="{{ route('informe.bodega1') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Informe de Bodega</p>
                                    </a>
                                </li>

                            @endcan
                        </ul>
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

                            <li class="nav-item">
                                <a href="{{ route('editar.registro.bodega2.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Editar Registro</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin2.equipo.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Equipos</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin2.proveedores.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Proveedores</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('reporte.ingreso.bodega2') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reportes</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan


                @can('grupo.bodega3.ingreso')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Ingreso
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @can('vista.grupo.bodega3.ingreso.nuevo-ingreso')
                        <li class="nav-item">
                            <a href="{{ route('registro.bodega3.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Ingreso</p>
                            </a>
                        </li>
                        @endcan

                        @can('vista.grupo.bodega3.ingreso.lista-de-proyectos')
                        <li class="nav-item">
                            <a href="{{ route('registro.ingreso.editar.bodega3.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista de Proyectos</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endcan

                @can('grupo.bodega3.proyectos')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Proyectos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @can('vista.grupo.bodega3.proyectos.lista-de-proyectos')
                        <li class="nav-item">
                            <a href="{{ route('verificacion.bodega3.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista de Proyectos</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endcan

                @can('grupo.bodega3.extras')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Extras
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @can('vista.grupo.bodega3.extras.encargados')
                        <li class="nav-item">
                            <a href="{{ route('admin3.encargados.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Encargados</p>
                            </a>
                        </li>
                        @endcan

                        @can('vista.grupo.bodega3.extras.servicios')
                        <li class="nav-item">
                            <a href="{{ route('admin3.servicios.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proyectos</p>
                            </a>
                        </li>
                        @endcan

                        @can('vista.grupo.bodega3.extras.cargos')
                        <li class="nav-item">
                            <a href="{{ route('admin3.cargos.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cargos</p>
                            </a>
                        </li>
                        @endcan

                        @can('vista.grupo.bodega3.extras.tipo-retiro')
                            <li class="nav-item">
                                <a href="{{ route('admin3.tipo.retiro.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tipo Retiros</p>
                                </a>
                            </li>
                        @endcan

                        @can('vista.grupo.bodega3.extras.bodega-ubicacion')
                        <li class="nav-item">
                            <a href="{{ route('admin3.bodega.ubicacion.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bodega Ubicación</p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endcan

                    @can('grupo.bodega4.bodega')
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
                                    <a href="{{ route('admin4.bodega.ingreso.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingreso</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin4.bodega.retiro.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Retiro</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan

                    @can('grupo.bodega4.registros')
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
                                    <a href="{{ route('admin4.extras.materiales.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Registro de Bodega</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin4.extras.listaproveedor.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lista de Proveedores</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan

                    @can('grupo.bodega4.reportes')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-file"></i>
                                <p>
                                    Reportes
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('reporte.ingreso.bodega4') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte Ingreso</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('reporte.retiro.bodega4') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte Retiro</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('informe.bodega4') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Informes</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan


            </ul>
        </nav>

    </div>
</aside>
