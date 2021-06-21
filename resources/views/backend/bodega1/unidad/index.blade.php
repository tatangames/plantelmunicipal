@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
@stop

<style>
    table{
        table-layout:fixed;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <button type="button" onclick="abrirModalAgregar()" class="btn btn-success btn-sm">
            <i class="fas fa-pencil-alt"></i>
            Registrar Unidad Medida
        </button>
    </div>
</section>

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
                    <h3 class="card-title">Listado Unidades de Medida</h3>
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
                    <h4 class="modal-title">Nueva Unidad de Medida</h4>
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
                                        <label>Nombre</label>
                                        <input type="text" maxlength="50" class="form-control" id="nombre-nuevo" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label>Magnitud</label>
                                        <input type="text" maxlength="50" class="form-control" id="magnitud-nuevo" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label>Simbolo</label>
                                        <input type="text" maxlength="50" class="form-control" id="simbolo-nuevo" placeholder="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="verificar()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Unidad de Medida</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="hidden" id="id-editar">
                                        <input type="text" maxlength="50" class="form-control" id="nombre-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Magnitud</label>
                                        <input type="text" maxlength="50" class="form-control" id="magnitud-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Simbolo</label>
                                        <input type="text" maxlength="50" class="form-control" id="simbolo-editar">
                                    </div>

                                    <div class="form-group" style="margin-left:20px">
                                        <label>Estado</label><br>
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
                    <button type="button" class="btn btn-success" onclick="editar()">Actualizar</button>
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
            var ruta = "{{ URL::to('unidad/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function abrirModalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        function verificar(){
            var nombre = document.getElementById('nombre-nuevo').value;
            var magnitud = document.getElementById('magnitud-nuevo').value;
            var simbolo = document.getElementById('simbolo-nuevo').value;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 50){
                toastMensaje('error', '50 caracteres máximo para Nombre');
                return;
            }

            if(magnitud === ''){
                toastMensaje('error', 'Magnitud es requerido');
                return;
            }

            if(magnitud.length > 50){
                toastMensaje('error', '50 caracteres máximo para Magnitud');
                return;
            }

            if(simbolo === ''){
                toastMensaje('error', 'Simbolo es requerido');
                return;
            }

            if(simbolo.length > 50){
                toastMensaje('error', '50 caracteres máximo para Simbolo');
                return;
            }


            let formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('magnitud', magnitud);
            formData.append('simbolo', simbolo);

            axios.post('/unidad/listado-nuevo', formData, {
            })
                .then((response) => {
                    if(response.data.success === 1){
                        toastMensaje('success', 'Agregado');
                        recargar();
                        $('#modalAgregar').modal('hide');
                    }else{
                        toastMensaje('error', 'Error');
                    }
                })
                .catch((error) => {
                    toastMensaje('error', 'Error');
                });
        }

        function recargar(){
            var ruta = "{{ url('/unidad/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        function modalInformacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post('/unidad/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.info.id);
                        $('#nombre-editar').val(response.data.info.nombre);
                        $('#magnitud-editar').val(response.data.info.magnitud);
                        $('#simbolo-editar').val(response.data.info.simbolo);

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

        function editar(){
            var id = document.getElementById('id-editar').value;
            var nombre = document.getElementById('nombre-editar').value;
            var magnitud = document.getElementById('magnitud-editar').value;
            var simbolo = document.getElementById('simbolo-editar').value;
            var t = document.getElementById('toggle-editar').checked;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 50){
                toastMensaje('error', '50 caracteres máximo para Nombre');
                return;
            }

            if(magnitud === ''){
                toastMensaje('error', 'Magnitud es requerido');
                return;
            }

            if(magnitud.length > 50){
                toastMensaje('error', '50 caracteres máximo para Magnitud');
                return;
            }

            if(simbolo === ''){
                toastMensaje('error', 'Simbolo es requerido');
                return;
            }

            if(simbolo.length > 50){
                toastMensaje('error', '50 caracteres máximo para Simbolo');
                return;
            }

            var toggleEditar = t ? 1 : 0;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('magnitud', magnitud);
            formData.append('simbolo', simbolo);
            formData.append('toggle', toggleEditar);

            axios.post('/unidad/listado-editar', formData, {
            })
                .then((response) => {
                    if(response.data.success === 1){
                        toastMensaje('success', 'Actualizado');
                        recargar();
                        $('#modalEditar').modal('hide');
                    }else{
                        toastMensaje('error', 'Error');
                    }
                })
                .catch((error) => {
                    toastMensaje('error', 'Error');
                });
        }


    </script>

@stop
