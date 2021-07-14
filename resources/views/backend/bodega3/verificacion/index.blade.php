@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
@stop

<style>
    table{
        /*Ajustar tablas*/
        table-layout:fixed;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <h1>Lista de Proyectos</h1>
    </div>
</section>

<div class="content-wrapper" style="margin-top: 10px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Listado</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="tablaDatatable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="modalAgregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Opciones</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevo">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <input type="hidden" id="id-global">
                                    </div>

                                    <center>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verSobrantes()">Existencias</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verEncargados()">Encargados</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verMateriales()">Lista de Materiales</button>
                                        </div>

                                        @can('vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.verificar-material')
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verRegistroIngreso()">Verificar Material</button>
                                        </div>
                                        @endcan

                                        @can('vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.editar-verificar-material')
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="editarMaterialVerificado()">Editar Material Verificado</button>
                                        </div>
                                        @endcan

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verPdf()">Generar Reporte</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verDocumentos()">Documentos</button>
                                        </div>

                                        @can('vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.retirar-material')
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="vistaRetiro()">Retiro de Material</button>
                                        </div>
                                        @endcan

                                        @can('vista.grupo.bodega3.proyectos.lista-de-proyectos.boton.editar-retirar-material')
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="vistaEditarRetiros()">Editar Material Retirado</button>
                                        </div>
                                        @endcan

                                    </center>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('sistema3/verificacion/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        // abrir modal con todas las opciones
        function verTodaOpciones(id){
            $('#modalAgregar').modal('show');
            $('#id-global').val(id);
        }

        // vista de encargados
        function verEncargados(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/verificacion/ver/encargados') }}/"+id;
        }

        // vista de materiales
        function verMateriales(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/verificacion/material/index') }}/"+id;
        }

        // vista para registrar un ingreso
        function verRegistroIngreso(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/verificacion/registro-material') }}/"+id;
        }


        // lo enviara a otra pantalla, con lista de materiales verificados
        // aqui tendra que seleccionar cual fue el que hizo
        function editarMaterialVerificado(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/verificacion/editar/material-index') }}/"+id;
        }

        // generar pdf
        function verPdf(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.open("{{ URL::to('sistema3/verificacion/material/pdf') }}/" + id);
        }

        // ver documento
        function verDocumentos(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/verificacion/lista-documentos') }}/"+id;
        }

        // vista para generar un retiro
        // vista para retirar material
        function vistaRetiro(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/retiromaterial/retiro-index') }}/"+id;
        }


        // vista para editar lista de retiros
        function vistaEditarRetiros(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/retiromaterial/ver/lista-retiros') }}/"+id;
        }

        // ver sobrantes
        function verSobrantes(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/verificacion/ver/lista-sobrantes') }}/"+id;
        }

        // recargar tablas
        function recargar(){
            var ruta = "{{ url('sistema3/verificacion/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }


    </script>

@stop
