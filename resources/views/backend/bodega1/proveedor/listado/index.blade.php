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

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Dirección: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="150" id="direccion-editar">
                                        <div class="error" id="divErrorDireccion"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre de la Persona de contácto: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="100" id="contacto-editar">
                                        <div class="error" id="divErrorPersona"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Teléfono Fijo: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" maxlength="8" id="telefono-editar" placeholder="Ejemplo: 24020000">
                                        <div class="error" id="divErrorTelefono"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Teléfono Móvil: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" maxlength="8" id="movil-editar" placeholder="Ejemplo: 75358565">
                                        <div class="error" id="divErrorMovil"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Correo Electrónico: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="100" id="correo-editar">
                                        <div class="error" id="divErrorCorreo"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Observaciones: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="300" id="observaciones-editar">
                                        <div class="error" id="divErrorObservaciones"></div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 25px">
                                    <label>Estado: </label><br>
                                    <label class="switch" style="margin-top:10px">
                                        <input type="checkbox" id="toggle-editar">
                                        <div class="slider round">
                                            <span class="on">Activo</span>
                                            <span class="off">Inactivo</span>
                                        </div>
                                    </label>
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


<div class="modal fade" id="modalInfo" style="min-width: 100%">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group" >
                                    <label>Nombre de la Empresa: </label><br>
                                    <input class="form-control" id="nombre-info">
                                </div>

                                <div class="form-group" >
                                    <label>Dirección: </label><br>
                                    <input class="form-control" id="direccion-info">
                                </div>

                                <div class="form-group" >
                                    <label>Contácto: </label><br>
                                    <input class="form-control" id="contacto-info">
                                </div>

                                <div class="form-group" >
                                    <label>Tel. Fijo: </label><br>
                                    <input class="form-control" id="telefono-info">
                                </div>

                                <div class="form-group" >
                                    <label>Tel. Móvil: </label><br>
                                    <input class="form-control" id="movil-info">
                                </div>

                                <div class="form-group" >
                                    <label>Correo: </label><br>
                                    <input class="form-control" id="correo-info">
                                </div>

                                <div class="form-group" >
                                    <label>Observaciones: </label><br>
                                    <input class="form-control" id="observaciones-info">
                                </div>

                                <div class="form-group" style="margin-top: 20px">
                                    <p id="estado-info" style="font-size: 15px">Estado: </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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
            var ruta = "{{ URL::to('/admin1/proveedor/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        // ver informacion de un proveedor
        function verInformacion(id){
            openLoading();
            document.getElementById("formulario-info").reset();

            axios.post('/admin1/proveedor/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalInfo').modal('show');
                        $('#nombre-info').val(response.data.info.empresa);
                        $('#direccion-info').val(response.data.info.direccion);
                        $('#contacto-info').val(response.data.info.nombrecontacto);

                        $('#telefono-info').val(response.data.info.telfijo);
                        $('#movil-info').val(response.data.info.telmovil);

                        $('#correo-info').val(response.data.info.correo);
                        $('#observaciones-info').val(response.data.info.observaciones);

                        if(response.data.info.activo == 1){
                            document.getElementById('estado-info').innerHTML = 'Estado:  Activo';
                            document.getElementById('estado-info').className = "badge bg-primary";
                        }else{
                            document.getElementById('estado-info').innerHTML = 'Estado:  Inactivo';
                            document.getElementById('estado-info').className = "badge bg-danger";
                        }

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

            axios.post('/admin1/proveedor/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.info.id);
                        $('#nombre-editar').val(response.data.info.empresa);
                        $('#direccion-editar').val(response.data.info.direccion);
                        $('#contacto-editar').val(response.data.info.nombrecontacto);

                        $('#telefono-editar').val(response.data.info.telfijo);
                        $('#movil-editar').val(response.data.info.telmovil);

                        $('#correo-editar').val(response.data.info.correo);
                        $('#observaciones-editar').val(response.data.info.observaciones);

                        if(response.data.info.activo == 0){
                            $("#toggle-editar").prop("checked", false);
                        }else{
                            $("#toggle-editar").prop("checked", true);
                        }

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
            var direccion = document.getElementById('direccion-editar').value;
            var persona = document.getElementById('contacto-editar').value;
            var telefono = document.getElementById('telefono-editar').value;
            var movil = document.getElementById('movil-editar').value;
            var correo = document.getElementById('correo-editar').value;
            var observaciones = document.getElementById('observaciones-editar').value;

            // bloqueos
            var boolNombre, boolDireccion, boolPersona, boolTelefono, boolMovil, boolCorreo,
                boolObservaciones = false;

            // validaciones
            if(nombre === '') {
                printError("divErrorNombre", "Por favor ingresar un nombre");
                boolNombre = false;
            } else {
                printError("divErrorNombre", "");
                boolNombre = true;
            }

            if(direccion.length > 150){
                printError("divErrorDireccion", "Máximo 150 caracteres");
                boolDireccion = false;
            }else{
                printError("divErrorDireccion", "");
                boolDireccion = true;
            }

            if(persona.length > 100){
                printError("divErrorPersona", "Máximo 100 caracteres");
                boolPersona = false;
            }else{
                printError("divErrorPersona", "");
                boolPersona = true;
            }

            if(telefono.length > 8){
                printError("divErrorTelefono", "Máximo 8 caracteres");
                boolTelefono = false;
            }else{
                printError("divErrorTelefono", "");
                boolTelefono = true;
            }

            if(movil.length > 8){
                printError("divErrorMovil", "Máximo 8 caracteres");
                boolMovil = false;
            }else{
                printError("divErrorMovil", "");
                boolMovil = true;
            }

            if(correo.length > 100){
                printError("divErrorCorreo", "Máximo 100 caracteres");
                boolCorreo = false;
            }else{
                printError("divErrorCorreo", "");
                boolCorreo = true;
            }

            if(observaciones.length > 300){
                printError("divErrorObservaciones", "Máximo 100 caracteres");
                boolObservaciones = false;
            }else{
                printError("divErrorObservaciones", "");
                boolObservaciones = true;
            }

            if((boolNombre && boolDireccion && boolPersona && boolTelefono && boolMovil &&
                boolCorreo && boolObservaciones) === true) {
                editarProveedor();
            }
        }

        function editarProveedor(){
            var id = document.getElementById('id-editar').value;
            var nombre = document.getElementById('nombre-editar').value;
            var direccion = document.getElementById('direccion-editar').value;
            var persona = document.getElementById('contacto-editar').value;
            var telfijo = document.getElementById('telefono-editar').value;
            var telmovil = document.getElementById('movil-editar').value;
            var correo = document.getElementById('correo-editar').value;
            var observaciones = document.getElementById('observaciones-editar').value;
            var t = document.getElementById('toggle-editar').checked;

            var toggleEditar = t ? 1 : 0;

            openLoading();
            var formData = new FormData();

            formData.append('id', id);
            formData.append('empresa', nombre);
            formData.append('direccion', direccion);
            formData.append('nombrecontacto', persona);
            formData.append('telfijo', telfijo);
            formData.append('telmovil', telmovil);
            formData.append('correo', correo);
            formData.append('observaciones', observaciones);
            formData.append('activo', toggleEditar);

            axios.post('/admin1/proveedor/listado-editar', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Actualizado');
                        $('#modalEditar').modal('hide');
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
