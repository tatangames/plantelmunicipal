@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
@stop

<style>
    .error {
        color: red;
        font-size: 15px;
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
            <div class="row">

                <div class="col-md-11">

                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Ingreso de Proveedores</h3>
                        </div>

                        <form id="formulario">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre de la Empresa: </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" maxlength="150" id="nombre-nuevo">
                                        <div class="error" id="divErrorNombre"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Dirección: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="150" id="direccion-nuevo">
                                        <div class="error" id="divErrorDireccion"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre de la Persona de contácto: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="100" id="persona-nuevo">
                                        <div class="error" id="divErrorPersona"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Teléfono Fijo: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" maxlength="8" id="telefono-nuevo" placeholder="Ejemplo: 24020000">
                                        <div class="error" id="divErrorTelefono"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Teléfono Móvil: </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" maxlength="8" id="movil-nuevo" placeholder="Ejemplo: 75358565">
                                        <div class="error" id="divErrorMovil"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Correo Electrónico: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="100" id="correo-nuevo">
                                        <div class="error" id="divErrorCorreo"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Observaciones: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" maxlength="300" id="observaciones-nuevo">
                                        <div class="error" id="divErrorObservaciones"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-success float-right" onclick="verificar()">Guardar</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>

    <script>

        function printError(elemId, hintMsg) {
            document.getElementById(elemId).innerHTML = hintMsg;
        }

        function verificar(){
            var nombre = document.getElementById('nombre-nuevo').value;
            var direccion = document.getElementById('direccion-nuevo').value;
            var persona = document.getElementById('persona-nuevo').value;
            var telefono = document.getElementById('telefono-nuevo').value;
            var movil = document.getElementById('movil-nuevo').value;
            var correo = document.getElementById('correo-nuevo').value;
            var observaciones = document.getElementById('observaciones-nuevo').value;

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
                registrar();
            }
        }

        function registrar(){

            var nombre = document.getElementById('nombre-nuevo').value;
            var direccion = document.getElementById('direccion-nuevo').value;
            var persona = document.getElementById('persona-nuevo').value;
            var telfijo = document.getElementById('telefono-nuevo').value;
            var telmovil = document.getElementById('movil-nuevo').value;
            var correo = document.getElementById('correo-nuevo').value;
            var observaciones = document.getElementById('observaciones-nuevo').value;

            openLoading();
            var formData = new FormData();

            formData.append('empresa', nombre);
            formData.append('direccion', direccion);
            formData.append('nombrecontacto', persona);
            formData.append('telfijo', telfijo);
            formData.append('telmovil', telmovil);
            formData.append('correo', correo);
            formData.append('observaciones', observaciones);

            axios.post('/proveedor/ingreso/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Proveedor Registrado');
                        limpiarFormulario();
                    }else{
                        toastMensaje('error', 'Error');
                    }

                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error');
                });
        }

        function limpiarFormulario(){
            var form = document.getElementById("formulario");
            form.reset();
        }

    </script>

@stop
