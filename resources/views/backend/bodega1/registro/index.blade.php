@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-select.min.css') }}" type="text/css" rel="stylesheet" />
@stop

<style>
    table{
        table-layout:fixed;
    }

</style>

<section class="content-header">
    <div class="container-fluid">
        @can('boton.grupo.bodega1.equipos.registrar-material.btn-agregar')
        <button type="button" onclick="abrirModalAgregar()" class="btn btn-success btn-sm">
            <i class="fas fa-pencil-alt"></i>
            Registrar Nuevo Material
        </button>
        @endcan
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
                    <h4 class="modal-title">Nuevo Material</h4>
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
                                        <input type="text" maxlength="300" class="form-control" id="nombre-nuevo" placeholder="Nombre">
                                    </div>

                                    <div class="form-group">
                                        <label>Código</label>
                                        <input type="text" maxlength="50" class="form-control" id="codigo-nuevo" placeholder="Código">
                                    </div>

                                    <div class="form-group row" style="margin-top: 30px">
                                        <label class="control-label">Ubicación: </label>
                                            <select id="select-bodega" class="form-control selectpicker" data-live-search="true">
                                                @foreach($bodega as $item)
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
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
                    <h4 class="modal-title">Editar Material</h4>
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
                                        <input type="text" maxlength="300" class="form-control" id="nombre-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Código</label>
                                        <input type="text" maxlength="50" class="form-control" id="codigo-editar">
                                    </div>

                                    <div class="form-group row" style="margin-top: 30px">
                                        <label class="control-label">Ubicación: </label>
                                        <select id="select-bodega-editar" class="form-control" >
                                        </select>
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
    <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('sistema1/materiales/listado-tabla') }}";
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
            var codigo = document.getElementById('codigo-nuevo').value;
            var bodega = document.getElementById('select-bodega').value;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 300){
                toastMensaje('error', '300 caracteres máximo para Nombre');
                return;
            }

            if(codigo.length > 50){
                toastMensaje('error', '50 caracteres máximo para Código');
                return;
            }

            let formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('codigo', codigo);
            formData.append('bodega', bodega);

            axios.post(url+'/sistema1/materiales/listado-nuevo', formData, {
            })
                .then((response) => {
                    if(response.data.success === 1){
                        alertaMensaje('warning', 'Nombre Repetido', 'Ingresar un nombre diferente');
                    }
                    else if(response.data.success === 2){
                        alertaMensaje('warning', 'Código Repetido', 'Ingresar un código diferente');
                    }
                    else if(response.data.success === 3){
                        toastMensaje('success', 'Agregado');
                        recargar();
                        $('#modalAgregar').modal('hide');
                    }
                    else{
                        toastMensaje('error', 'Error');
                    }
                })
                .catch((error) => {
                    toastMensaje('error', 'Error');
                });
        }

        function recargar(){
            var ruta = "{{ url('sistema1/materiales/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        function modalInformacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post(url+'/sistema1/materiales/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.info.id);
                        $('#nombre-editar').val(response.data.info.nombre);
                        $('#codigo-editar').val(response.data.info.codigo);

                        document.getElementById("select-bodega-editar").options.length = 0;

                        $.each(response.data.ubicaciones, function( key, val ){
                            if(response.data.info.id_bodega_num == val.id){
                                $('#select-bodega-editar').append('<option value="' +val.id +'" selected="selected">'+val.nombre+'</option>');
                            }else{
                                $('#select-bodega-editar').append('<option value="' +val.id +'">'+val.nombre+'</option>');
                            }
                        });
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
            var codigo = document.getElementById('codigo-editar').value;
            var bodega = document.getElementById('select-bodega-editar').value;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 300){
                toastMensaje('error', '300 caracteres máximo para Nombre');
                return;
            }

            if(codigo.length > 50){
                toastMensaje('error', '50 caracteres máximo para Código');
                return;
            }


            let formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('codigo', codigo);
            formData.append('bodega', bodega);

            axios.post(url+'/sistema1/materiales/listado-editar', formData, {
            })
                .then((response) => {

                    if(response.data.success === 1){
                        alertaMensaje('warning', 'Nombre Repetido', 'Ingresar un nombre diferente');
                    }
                    else if(response.data.success === 2){
                        alertaMensaje('warning', 'Código Repetido', 'Ingresar un código diferente');
                    }
                    else if(response.data.success === 3){
                        toastMensaje('success', 'Actualizado');
                        recargar();
                        $('#modalEditar').modal('hide');
                    }
                    else{
                        toastMensaje('error', 'Error al Editar');
                    }
                })
                .catch((error) => {
                    toastMensaje('error', 'Error al Editar');
                });
        }

        // ver lista de ingresos de un material por id
        function historialIngreso(id){
            window.location.href="{{ url('sistema1/materiales/histo/ingreso') }}/"+id;
        }

        // ver lista de retiros de un material por id
        function historialRetiro(id){
            window.location.href="{{ url('sistema1/materiales/histo/retiro') }}/"+id;
        }


    </script>

@stop
