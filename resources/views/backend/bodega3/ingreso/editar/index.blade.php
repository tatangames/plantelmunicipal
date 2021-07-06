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
                                            <button type="button" class="btn btn-success" onclick="verSobrantes()">Ver Sobrantes</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verEncargados()">Encargados</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verMateriales()">Lista de Materiales</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verMaterialesEditar()">Editar Proyecto</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verAgregarMateriales()">Agregar más Materiales</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verDocumentos()">Ver Documentos</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verPdf()">Generar PDF</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verListaVerificados()">Ver Lista Verificados</button>
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" onclick="verListaRetiros()">Ver Lista Retiros</button>
                                        </div>

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
            var ruta = "{{ URL::to('sistema3/bodega3/ingresoeditar/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        // abrir modal con todas las opciones
        function verTodaOpciones(id){
            $('#modalAgregar').modal('show');
            $('#id-global').val(id);
        }


        // ver lista de encargados
        function verEncargados(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingreso/ver/encargados') }}/"+id;
        }

        // unicamente ver materiales
        function verMateriales(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingreso/material/index') }}/"+id;
        }

        // ver lista de materiales para editar
        function verMaterialesEditar(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingresoeditar/editar-material') }}/"+id;
        }

        // agregar un extra material
        function verAgregarMateriales(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/bodega3/registro-extra-material') }}/"+id;
        }

        // ver lista de documentos agregado a esta carpeta
        function verDocumentos(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingreso/lista-documentos') }}/"+id;
        }

        // genera un pdf con la informacion del proyecto
        function verPdf(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.open("{{ URL::to('sistema3/ingresoeditar/material/pdf') }}/" + id);
        }

        // recargar tablas
        function recargar(){
            var ruta = "{{ url('sistema3/verificacion/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        // ver lista de retiros
        function verListaRetiros(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingreso/ver/lista-de-retiros') }}/"+id;
        }

        // ver sobrantes
        function verSobrantes(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingreso/ver/lista-sobrantes') }}/"+id;
        }

        // ver lista de verificados
        function verListaVerificados(){
            $('#modalAgregar').modal('hide');
            var id = document.getElementById('id-global').value;
            window.location.href="{{ url('sistema3/ingreso/ver/lista-de-verificados') }}/"+id;
        }


    </script>

@stop
