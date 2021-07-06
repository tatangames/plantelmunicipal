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
                        <h3 class="card-title">Retiro de Material</h3>
                    </div>
                    <form>
                        <div class="card-body">

                            <div class="form-group col-md-6">
                                <label>Tipo de Retiro</label>
                                <select class="form-control" id="select-tiporetiro">
                                    @foreach($tiporetiro as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Bodega de Retiro</label>
                                <select class="form-control" id="select-bodega">
                                    @foreach($bodega as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group row" style="margin-top: 30px; margin-left: 3px">
                                <label class="control-label">Notas: </label>
                                <div class="col-sm-5" style="margin-left: 18px">
                                    <input id="nota-general" placeholder="Opcional" maxlength="500" class="form-control" type="text" value="">
                                </div>
                            </div>

                            <table class="table" id="matriz"  data-toggle="table">
                                <thead>
                                <tr>
                                    <th scope="col" style="max-width: 75px">Nombre</th>
                                    <th scope="col" style="max-width: 15px">Existencia Verificada</th>
                                    <th scope="col" style="max-width: 15px">Existencia Retirada</th>
                                    <th scope="col" style="max-width: 15px">Existencia A Retirar</th>
                                </tr>
                                </thead>
                                <tbody id="myTbody">

                                @foreach($listado as $dato)

                                    <tr>
                                        <td style="max-width: 75px">
                                            <input name="identificador[]" type="hidden" value="{{ $dato->id }}">
                                            <input name="material[]" disabled id="{{ $dato->id }}" class="form-control" type="text" value="{{ $dato->nombre }}">
                                        </td>
                                        <td style="max-width: 15px"><input name="cmaxima[]" disabled class="form-control" value="{{ $dato->sumaverificado }}" ></td>
                                        <td style="max-width: 15px"><input name="registrado[]" disabled class="form-control" value="{{ $dato->registrado }}" ></td>
                                        <td style="max-width: 15px"><input name="cregistrar[]" class="form-control" value="0" ></td>
                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                            <br>
                            <div class="card-footer">
                                <button id="btnguardar" type="button"  class="btn btn-success float-right" onclick="preguntarRevision();">Guardar Retiro</button>
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

    <script>

        function preguntarRevision(){
            Swal.fire({
                title: 'Registrar Retiro?',
                text: "",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Registrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    verificar();
                }
            })
        }

        // verificar que todos los datos a ingresar sean correctos
        function verificar(){

            // minimo se necesitara 1 registro para guardar
            var nRegistro = $('#matriz >tbody >tr').length;
            if (nRegistro <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo');
                return;
            }

            var notaGeneral = document.getElementById('nota-general').value;

            if(notaGeneral.length > 500){
                toastMensaje('error', '500 caracteres máximo para Nota General');
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
            var nota = document.getElementById('nota-general').value;
            var tiporetiro = document.getElementById('select-tiporetiro').value;
            var bodega = document.getElementById('select-bodega').value;

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

            axios.post(url+'/sistema3/retiromaterial/registrar/retiro', formData, {
            })
                .then((response) => {
                    closeLoading();

                    // no se va a registrar nada de nada
                    if(response.data.success === 1){
                        // material no encontrado
                        alertaMensaje('warning','No hay Registro','No hay ninguna cantidad a Registrar en la lista de Materiales para Retirar');
                    }

                    // un material supera las unidad maximas ingresadas
                    else if(response.data.success === 2){
                        // no hay unidades suficientes para el retiro
                        alertaMensaje('warning','Unidades Superadas','En la fila "'+(response.data.fila)+'". El material con nombre: "'+(response.data.nombre)+'" \n supera a las unidades Verificadas: '
                            + '"'+(response.data.total)+'"');
                    }
                    else if(response.data.success === 3){
                        // registrado el retiro correctamente
                        alertaCorrecto();
                    }
                    else{
                        toastMensaje('error', 'Error al Retirar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al Retirar');
                });
        }


        function alertaCorrecto(){

            Swal.fire({
                title: 'Retiro Correcto',
                text: "El retiro de los materiales se ha Registrado",
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
