@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-select.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" rel="stylesheet" />

@stop

<section class="content-header">
    <div class="container-fluid">

    </div>
</section>

<section class="content">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-12">
                <div class="card card-green">
                    <div class="card-header">
                        <h3 class="card-title">Materiales</h3>
                    </div>
                    <form>
                        <div class="card-body">


                            <div class="form-group col-md-6">
                                <label>Tipo de Proyecto</label>
                                <select class="form-control" id="select-servicio">

                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Proyecto</label>
                                <input type="text" maxlength="800" class="form-control" id="nombre-editar" value="{{ $nombre }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Destino</label>
                                <input type="text" maxlength="800" class="form-control" id="destino-editar" value="{{ $destino }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Código</label>
                                <input type="text" maxlength="150" class="form-control" id="codigo-editar" value="{{ $codigo }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nota</label>
                                <input type="text" maxlength="300" class="form-control" id="nota-editar" value="{{ $nota }}">
                            </div>


                            <table class="table" id="matriz"  data-toggle="table">
                                <thead>
                                <tr>
                                    <th scope="col" style="max-width: 75px">Nombre</th>
                                    <th scope="col" style="max-width: 15px">Precio Unitario</th>
                                    <th scope="col" style="max-width: 15px">Cantidad</th>
                                </tr>
                                </thead>
                                <tbody id="myTbody">

                                @foreach($listado as $dato)

                                    <tr>
                                        <td style="max-width: 75px">
                                            <input name="identificador[]" type="hidden" value="{{ $dato->id }}">
                                            <input name="material[]" maxlength="300" class="form-control" type="text" value="{{ $dato->nombre }}">
                                        </td>
                                        <td style="max-width: 15px"><input name="precio[]" class="form-control" value="{{ $dato->preciounitario }}"></td>
                                        <td style="max-width: 15px"><input name="cantidad[]" class="form-control" value="{{ $dato->cantidad }}"></td>
                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                            <br>
                            <div class="card-footer">
                                <button id="btnguardar" type="button"  class="btn btn-success float-right" onclick="verificar();">Guardar Registros</button>
                            </div>

                        </div>


                    </form>
                </div>

            </div>

        </div>
    </div>
</section>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            var idservicio = {{ $idservicio }};

            @foreach($lista as $data)

            var identi = {{ $data->id }};

            if(idservicio == identi){
                $('#select-servicio').append('<option value="' + '{{ $data->id }}' +'" selected="selected">'+ '{{ $data->nombre }}' +'</option>');
            }else{
                $('#select-servicio').append('<option value="' + '{{ $data->id }}' +'">'+ '{{ $data->nombre }}' +'</option>');
            }

            @endforeach

        });
    </script>

    <script>

        // verificar que todos los datos a ingresar sean correctos
        function verificar(){

            Swal.fire({
                title: 'Editar Materiales?',
                text: "",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Modificar'
            }).then((result) => {
                if (result.isConfirmed) {
                    revisar();
                }
            })
        }

        function revisar(){
            // minimo se necesitara 1 registro para guardar
            var nRegistro = $('#matriz >tbody >tr').length;
            if (nRegistro <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe editar 1 registro como mínimo');
                return;
            }

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var precio = $("input[name='precio[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;
            var reglaNumeroEntero = /^[0-9]\d*$/;

            var nombre = document.getElementById('nombre-editar').value;
            var destino = document.getElementById('destino-editar').value;
            var codigo = document.getElementById('codigo-editar').value;
            var nota = document.getElementById('nota-editar').value;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 800){
                toastMensaje('error', 'Máximo 800 caracteres para Nombre');
                return;
            }

            if(destino === ''){
                toastMensaje('error', 'Destino es requerido');
                return;
            }

            if(destino.length > 800){
                toastMensaje('error', 'Máximo 800 caracteres para Destino');
                return;
            }

            if(codigo.length > 150){
                toastMensaje('error', 'Máximo 150 caracteres para Código');
                return;
            }

            if(nota.length > 300){
                toastMensaje('error', 'Máximo 300 caracteres para Nota');
                return;
            }


            for(var a = 0; a < material.length; a++){

                var datoMaterial = material[a];

                if(datoMaterial === ''){
                    alertaMensaje('warning','Campo Requerido','En la fila "'+(a+1)+'", se debe ingresar nombre de Material');
                    return;
                }

                if(datoMaterial.length > 300){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (a+1) + '", Máximo son 300 caracteres');
                    return;
                }
            }

            // verificar todos los campos de precio unitario
            for(var b = 0; b < precio.length; b++){

                var datoPrecio = precio[b];

                if(datoPrecio === ''){
                    alertaMensaje('warning','Campo Requerido','En la fila "'+(b+1)+'", se debe ingresar el Precio Unitario');
                    return;
                }

                if(!datoPrecio.match(reglaNumeroDecimal)) {
                    alertaMensaje('warning','Inválido', 'En la fila "' + (b+1) + '", el Precio Unitario no es valido');
                    return;
                }

                if(datoPrecio <= 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (b+1) + '", el Precio Unitario no es válido. No números negativos o precio a 0');
                    return;
                }

                if(datoPrecio > 1000000){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (b+1) + '", el Precio Unitario no debe superar 1 millón');
                    return;
                }
            }

            // verificar todos los campos de cantidad
            for(var d = 0; d < cantidad.length; d++){

                var datoCantidad = cantidad[d];

                if(datoCantidad === ''){
                    alertaMensaje('warning','Campo Requerido','En la fila "'+(d+1)+'", se debe ingresar la Cantidad');
                    return;
                }

                if(!datoCantidad.match(reglaNumeroEntero)) {
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es valida. Números validos del 1 en adelante. No Decimales')
                    return;
                }

                if(datoCantidad <= 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida, no Números negativos o cantidad a 0')
                    return;
                }

                if(datoCantidad > 1000000){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no debe superar 1 millón');
                    return;
                }
            }

            guardarRegistro();
        }

        function guardarRegistro(){

            openLoading();

            var id = {{ $id }};

            var identificador = $("input[name='identificador[]']").map(function(){return $(this).val();}).get();
            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var precio = $("input[name='precio[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            var nombre = document.getElementById('nombre-editar').value;
            var destino = document.getElementById('destino-editar').value;
            var codigo = document.getElementById('codigo-editar').value;
            var nota = document.getElementById('nota-editar').value;

            var selectservicio = document.getElementById('select-servicio').value;

            let formData = new FormData();

            formData.append('id', id);

            formData.append('nombre', nombre);
            formData.append('destino', destino);
            formData.append('codigo', codigo);
            formData.append('nota', nota);
            formData.append('selectservicio', selectservicio);

            for(var a = 0; a < identificador.length; a++){
                formData.append('identificador[]', identificador[a]);
                formData.append('material[]', material[a]);
                formData.append('precio[]', precio[a]);
                formData.append('cantidad[]', cantidad[a]);
            }

            axios.post(url+'/sistema3/ingresoeditar/modificar-materiales', formData, {
            })
                .then((response) => {
                    closeLoading();

                    // modificado
                    if(response.data.success === 1){
                        toastMensaje('success', 'Materiales Modificados');
                    }
                    else{
                        toastMensaje('error', 'Error al Modificar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al Modificar');
                });
        }


    </script>



@stop
