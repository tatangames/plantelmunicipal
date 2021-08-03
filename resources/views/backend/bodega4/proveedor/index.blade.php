@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/responsive.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />

@stop

<style>
    table{
        table-layout:fixed;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <button type="button" onclick="abrirModalAgregar()" class="btn btn-success btn-sm">
                    <i class="fas fa-pencil-alt"></i>
                    Nuevo Proveedor
                </button>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Listado de Proveedores</h3>
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

</div>

<div class="modal fade" id="modalAgregar" style="min-width: 100%">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nuevo Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-nuevo">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre de la Empresa: </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" maxlength="150" id="nombre-nuevo">
                                        <div class="error" id="divErrorNombre2"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="verificarNuevo()">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEditar" style="min-width: 100%">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modificar Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-editar">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre de la Empresa: </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" maxlength="150" id="nombre-editar">
                                        <input type="hidden" id="id-editar">
                                        <div class="error" id="divErrorNombre"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="verificarEditar()">Guardar</button>
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

    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('sistema4/proveedores/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function abrirModalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        // recargar
        function recargar(){
            var ruta = "{{ url('sistema4/proveedores/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        }

        // ver informacion de un proveedor
        function verInformacion(id){
            openLoading();
            document.getElementById("formulario-info").reset();

            axios.post(url+'/sistema4/proveedores/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modalInfo').modal('show');
                        $('#nombre-info').val(response.data.info.empresa);

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }

        function verInformacionEditar(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post(url+'/sistema4/proveedores/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.info.id);
                        $('#nombre-editar').val(response.data.info.empresa);

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }

        function printError(elemId, hintMsg) {
            document.getElementById(elemId).innerHTML = hintMsg;
        }

        // verificar los datos que se van a editar
        function verificarEditar(){
            var nombre = document.getElementById('nombre-editar').value;

            // bloqueos
                var boolNombre = false;

            // validaciones
            if(nombre === '') {
                printError("divErrorNombre", "Por favor ingresar un nombre");
                boolNombre = false;
            } else {
                printError("divErrorNombre", "");
                boolNombre = true;
            }

            if(boolNombre) {
                editarProveedor();
            }
        }

        function editarProveedor(){
            var id = document.getElementById('id-editar').value;
            var nombre = document.getElementById('nombre-editar').value;

            openLoading();
            var formData = new FormData();

            formData.append('id', id);
            formData.append('empresa', nombre);

            axios.post(url+'/sistema4/proveedores/listado-editar', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Actualizado');
                        $('#modalEditar').modal('hide');

                        recargar();
                    }else{
                        toastMensaje('error', 'Error');
                    }

                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error');
                });
        }


        // ***

        function verificarNuevo(){
            var nombre = document.getElementById('nombre-nuevo').value;

            // bloqueos
            var boolNombre = false;

            // validaciones
            if(nombre === '') {
                printError("divErrorNombre2", "Por favor ingresar un nombre");
                boolNombre = false;
            } else {
                printError("divErrorNombre2", "");
                boolNombre = true;
            }

            if(boolNombre) {
                nuevoProveedor();
            }
        }

        // registrar nuevo proveedor
        function nuevoProveedor(){

            var nombre = document.getElementById('nombre-nuevo').value;

            openLoading();
            var formData = new FormData();

            formData.append('empresa', nombre);

            axios.post(url+'/sistema4/proveedores/ingreso/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Agregado');
                        $('#modalAgregar').modal('hide');
                        recargar();
                    }else{
                        toastMensaje('error', 'Error');
                    }

                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error');
                });
        }

    </script>

@stop
