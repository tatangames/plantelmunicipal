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
                        <h3 class="card-title">Editar Material Retirado</h3>
                    </div>
                    <form>
                        <div class="card-body">

                            <div class="form-group col-md-6">
                                <label>Tipo de Retiro</label>
                                <select class="form-control" id="select-retiro">

                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Ubicación de Bodega</label>
                                <select class="form-control" id="select-bodega">

                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nota</label>
                                <input type="text" maxlength="500" class="form-control" id="nota-nuevo" value="{{ $nota }}">
                            </div>

                            <table class="table" id="matriz"  data-toggle="table">
                                <thead>
                                <tr>
                                    <th scope="col" style="max-width: 75px">Nombre</th>
                                    <th scope="col" style="max-width: 15px">Existencia Verificada</th>
                                    <th scope="col" style="max-width: 15px">Existencia Retirada</th>
                                    <th scope="col" style="max-width: 15px">Existencia A Editar</th>
                                </tr>
                                </thead>
                                <tbody id="myTbody">

                                @foreach($listado as $dato)

                                    <tr>
                                        <td style="max-width: 75px">
                                            <input name="identificador[]" type="hidden" value="{{ $dato->id }}">
                                            <input name="material[]" disabled class="form-control" type="text" value="{{ $dato->nombre }}">
                                        </td>
                                        <td style="max-width: 15px"><input name="cmaxima[]" disabled class="form-control" value="{{ $dato->cantidadmax }}" ></td>
                                        <td style="max-width: 15px"><input name="registrado[]" disabled class="form-control" value="{{ $dato->cantidadretirada }}" ></td>
                                        <td style="max-width: 15px"><input name="cregistrar[]" class="form-control" value="{{ $dato->cantidad }}" ></td>
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

            var idtiporetiro = {{ $idtiporetiro }};

            @foreach($tiporetiro as $data)

            var identi = {{ $data->id }};

            if(idtiporetiro == identi){
                $('#select-retiro').append('<option value="' + '{{ $data->id }}' +'" selected="selected">'+ '{{ $data->nombre }}' +'</option>');
            }else{
                $('#select-retiro').append('<option value="' + '{{ $data->id }}' +'">'+ '{{ $data->nombre }}' +'</option>');
            }

            @endforeach

            var idbodega = {{ $idbodega }};

            @foreach($bodega as $data)

            var identibode = {{ $data->id }};

            if(idbodega == identibode){
                $('#select-bodega').append('<option value="' + '{{ $data->id }}' +'" selected="selected">'+ '{{ $data->nombre }}' +'</option>');
            }else{
                $('#select-bodega').append('<option value="' + '{{ $data->id }}' +'">'+ '{{ $data->nombre }}' +'</option>');
            }

            @endforeach

        });
    </script>

    <script>

        // verificar que todos los datos a ingresar sean correctos
        function verificar(){

            Swal.fire({
                title: 'Verificar Retiro?',
                text: "",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Verificar'
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
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo');
                return;
            }

            var nota = document.getElementById('nota-nuevo').value;

            if(nota.length > 500){
                toastMensaje('error', 'Máximo 500 caracteres para Nota');
                return;
            }

            var cantidad = $("input[name='cregistrar[]']").map(function(){return $(this).val();}).get();

            var reglaNumeroEntero = /^[0-9]\d*$/;

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

                // si permitimos cantidad igual a cero, porque si ingreso por equivocacion
                // no deberia sumar en la cantidad verificada total
                if(datoCantidad < 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida, no Números negativos')
                    return;
                }
            }

            guardarRegistro();
        }

        function guardarRegistro(){

            openLoading();

            // verificar los primeros campos select
            var nota = document.getElementById('nota-nuevo').value;
            var tiporetiro = document.getElementById('select-retiro').value;
            var bodega = document.getElementById('select-bodega').value;

            // id de tabla verificado_ingreso_b3
            var id = {{ $id }};

            var identificador = $("input[name='identificador[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cregistrar[]']").map(function(){return $(this).val();}).get();

            let formData = new FormData();

            formData.append('id', id);
            formData.append('nota', nota);
            formData.append('tiporetiro', tiporetiro);
            formData.append('bodega', bodega);

            for(var a = 0; a < identificador.length; a++){
                formData.append('identificador[]', identificador[a]);
                formData.append('cantidad[]', cantidad[a]);
            }

            axios.post(url+'/sistema3/retiromaterial/vistaeditarmaterial/modificarretiro', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        // no hay unidades suficientes para el retiro
                        alertaMensaje('warning','Unidades Superadas','En la fila "'+(response.data.fila)+'". El material con nombre: "'+(response.data.nombre)+'" \n supera a las unidades maximas Verificadas: '
                            + '"'+(response.data.total)+'"');
                    }
                    else if(response.data.success === 2){
                        // editar correctamente
                        alertaCorrecto();
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

        function alertaCorrecto(){

            Swal.fire({
                title: 'Retiro Modificado',
                text: "Se ha modificado la lista de retiro",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#28a745',
                closeOnClickOutside: false,
                allowOutsideClick: false,
                confirmButtonText: 'Recargar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            })
        }


    </script>



@stop
