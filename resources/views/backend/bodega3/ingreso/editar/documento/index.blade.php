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
        <button type="button" onclick="abrirModalAgregar()" class="btn btn-success btn-sm">
            <i class="fas fa-pencil-alt"></i>
            Nuevo Documento
        </button>
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
                    <h4 class="modal-title">Nuevo Documento</h4>
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
                                        <label>Descripción Documento</label>
                                        <input type="text" maxlength="100" class="form-control" id="nombre-nuevo" placeholder="Opcional">
                                    </div>

                                    <div class="form-group">
                                        <label>Documento</label>
                                        <input type="file" class="form-control" id="documento" accept="application/pdf, image/jpeg, image/jpg, image/png, .csv, .doc, .docx, .xlsx" />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="nuevo()">Agregar</button>
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

            var id = {{ $id }};
            var ruta = "{{ url('sistema3/ingreso/lista-documentos/tabla/') }}/"+id;
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>
        function abrirModalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }


        function nuevo(){
            var id = {{ $id }}; // id ingresos_b3
            var nombredoc = document.getElementById('nombre-nuevo').value;
            var doc = document.getElementById('documento');

            if(doc.files && doc.files[0]){ // si trae documento
                if (!doc.files[0].type.match('application/pdf|image/jpeg|image/jpeg|image/png|csv|doc|docx|xlsx')){
                    alertaMensaje('warning','Inválido', 'Formato permitido: .pdf e imagenes');
                    return false;
                }
            }else{
                alertaMensaje('warning','Requerido', 'Documento PDF es Requerido');
                return false;
            }

            if(nombredoc.length > 100){
                alertaMensaje('warning','Inválido', 'Máximo 100 caracteres para Nombre Documento');
                return;
            }

            openLoading()
            var formData = new FormData();
            formData.append('id', id);
            formData.append('nombredoc', nombredoc);
            formData.append('documento', doc.files[0]);

            axios.post(url+'/sistema3/ingreso/nuevo-documento', formData, {
            })
                .then((response) => {
                    closeLoading()
                    if(response.data.success === 1){
                        $('#modalAgregar').modal('hide');
                        toastMensaje('success', 'Agregado');
                        recargar();
                    }else{
                        toastMensaje('error', 'Error al guardar');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Error al guardar');
                });
        }

        function recargar(){
            var id = {{ $id }};
            var ruta = "{{ url('sistema3/ingreso/lista-documentos/tabla/') }}/"+id;
            $('#tablaDatatable').load(ruta);
        }

        function verBorrar(id){

            Swal.fire({
                title: 'Borrar Documento?',
                text: "",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Si'
            }).then((result) => {
                if (result.isConfirmed) {
                    borrarDocumento(id);
                }
            })
        }

        function borrarDocumento(id){

            openLoading()
            var formData = new FormData();
            formData.append('id', id);

            axios.post(url+'/sistema3/ingreso/borrar-documento', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Borrado');
                        recargar();
                    }else{
                        toastMensaje('error', 'Error al borrar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al guardar');
                });
        }

    </script>


@stop
