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
                        <h3 class="card-title">Ingreso de Material, Herramienta y Equipo</h3>
                    </div>
                    <form>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="form-inline">
                                    <label class="control-label">Condición: </label>
                                    <select class="form-control" id="select-condicion" style="width: 15%; margin-left: 20px;">
                                        @foreach($condicion as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>

                                    &nbsp;&nbsp;
                                    <label class="control-label" style="margin-left: 20px">Tipo: </label>
                                    <select id="select-tipomaterial" class="form-control col-md-3" style="margin-left: 14px;">
                                        @foreach($tipomaterial as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 30px">
                                <label class="control-label">Equipo: </label>
                                <div class="col-sm-5" style="margin-left: 40px">
                                    <select id="select-equipo" class="form-control selectpicker" data-live-search="true">
                                        @foreach($equipo as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 30px">
                                <label class="control-label">Proveedor: </label>
                                <div class="col-sm-10" style="margin-left: 18px">
                                    <select id="select-proveedor" class="form-control selectpicker" data-live-search="true">
                                        @foreach($proveedores as $item)
                                            <option value="{{$item->id}}">{{$item->empresa}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table" id="matriz"  data-toggle="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Unidad de Medida</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio Unitario</th>

                                    <th scope="col">Opciones</th>
                                </tr>
                                </thead>
                                <tbody id="myTbody">

                                <tr id="0">
                                    <td><p name="fila[]" disabled id="fila0" class="form-control" style="max-width: 65px">1</td>
                                    <td><input name="material[]" id="material0" onkeydown="buscarNombre(this.id)" maxlength="300" class="form-control" type="text" value="" autocomplete="off"></td>
                                    <td><input name="descripcion[]" maxlength="300" class="form-control" type="text" value=""></td>
                                    <td><select name="unidadmedida[]" class="form-control seleccion" style="max-width: 110px">
                                            @foreach($unidad as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                            @endforeach
                                        </select></td>
                                    <td><input name="cantidad[]" class="form-control" type="number" step="1" style="max-width: 85px" ></td>
                                    <td><input name="preciounitario[]" class="form-control" type="number" step=".01" style="max-width: 105px" ></td>
                                    <td><button type="button" class="btn btn-block btn-danger" id="btnBorrar" onclick="borrarFila(this)">Borrar</button></td>
                                </tr>

                                </tbody>

                            </table>

                            <br>
                            <button type="button" class="btn btn-block btn-success" id="btnAdd">Agregar Fila</button>
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

    <script>

        // busqueda de nombre o por codigo (solo se mostrara el nombre)
        function buscarNombre(value){
            $('#'+(value)+'').autocomplete({
                source: function(request, response){

                    axios.post('/admin1/bodega/buscar/material', {
                        'nombre' : request.term
                    })
                        .then((res) => {
                            response(res.data);
                        })
                        .catch((error) => {
                        });
                }
            });
        }

        // filas de la tabla
        $(document).ready(function () {
            $("#btnAdd").on("click", function () {

                var nFilas = $('#matriz >tbody >tr').length;
                nFilas += 1;

                //agrega las filas dinamicamente

                var markup = "<tr id='"+(nFilas)+"'>"+

                    "<td>"+
                    "<p id='fila"+(nFilas)+"' class='form-control' style='max-width: 65px'>"+(nFilas)+"</p>"+
                    "</td>"+

                    "<td>"+
                    "<input name='material[]' id='material"+(nFilas)+"' onkeydown='buscarNombre(this.id)' maxlength='300' class='form-control' type='text' value=''>"+
                    "</td>"+

                    "<td>"+
                    "<input name='descripcion[]' maxlength='300' class='form-control' type='text' value=''>"+
                    "</td>"+

                    "<td>"+
                    "<select class='form-control seleccion' style='max-width: 110px' name='unidadmedida[]'"+
                    "<option value='0'>Seleccionar Unidad</option>"+
                    "@foreach($unidad as $data)"+
                    "<option value='{{ $data->id }}'>{{ $data->nombre }}</option>"+
                    "@endforeach>"+
                    "</select>"+
                    "</td>"+

                    "<td>"+
                    "<input name='cantidad[]' class='form-control' style='max-width: 85px' type='number' step='1' value=''/>"+
                    "</td>"+

                    "<td>"+
                    "<input name='preciounitario[]' class='form-control' type='number' step='.01' style='max-width: 105px' value=''/>"+
                    "</td>"+

                    "<td>"+
                    "<button type='button' class='btn btn-block btn-danger' onclick='borrarFila(this)'>Borrar</button>"+
                    "</td>"+

                    "</tr>";

                $("tbody").append(markup);

            });
        });

        // verificar que todos los datos a ingresar sean correctos
        function verificar(){

            // minimo se necesitara 1 registro para guardar
            var nRegistro = $('#matriz >tbody >tr').length;
            if (nRegistro <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo');
                return;
            }

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var descripcion = $("input[name='descripcion[]']").map(function(){return $(this).val();}).get();
            var preciounitario = $("input[name='preciounitario[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/; // validacion de numeros y puntos decimales
            var reglaNumeroEntero = /^[0-9]\d*$/;

            // verificar el campo Material
            for(var a = 0; a < material.length; a++){

                var datoMaterial = material[a];

                if(datoMaterial === ''){
                    alertaMensaje('warning','Campo Requerido','En la fila "'+(a+1)+'", se debe ingresar el nombre del Material');
                    return;
                }

                if(datoMaterial.length > 300) {
                    alertaMensaje('warning','Inválido', 'En la fila "' + (a+1) + '", los caracteres máximo son 300 y ha ingresado: "'+datoMaterial.length+'"')
                    return;
                }
            }

            // verificar el campo Descripcion
            for(var b = 0; b < descripcion.length; b++){

                var datoDescripcion = descripcion[b];

                if(datoDescripcion === ''){
                    // nada
                }else{
                    if(datoDescripcion.length > 300) {
                        alertaMensaje('warning','Inválido', 'En la fila "' + (b+1) + '", los caracteres máximo son 300 y ha ingresado: "'+datoDescripcion.length+'"')
                        return;
                    }
                }
            }

            // verificar todos los campos de precio unitario
            for(var c = 0; c < preciounitario.length; c++){

                var datoPrecioUnitario = preciounitario[c];

                if(datoPrecioUnitario === ''){
                    alertaMensaje('warning','Campo Requerido','En la fila "'+(c+1)+'", se debe ingresar el Precio Unitario');
                    return;
                }

                if(!datoPrecioUnitario.match(reglaNumeroDecimal)) {
                    alertaMensaje('warning','Inválido', 'En la fila "' + (c+1) + '", el número del Precio Unitario no es valido')
                    return;
                }

                if(datoPrecioUnitario <= 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (c+1) + '", el número del Precio Unitario no es valido, debe ser mayor a 0')
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
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida. \n No se permite Números con Decimales')
                    return;
                }

                if(datoCantidad <= 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida, debe ser mayor a 0')
                    return;
                }
            }

            guardarRegistro();
        }

        // guardado de registros del ingreso
        function guardarRegistro(){

            openLoading();

            // verificar los primeros campos select
            var condicion = document.getElementById('select-condicion').value;
            var tipomaterial = document.getElementById('select-tipomaterial').value;
            var proveedor = document.getElementById('select-proveedor').value;
            var equipo = document.getElementById('select-equipo').value;

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var descripcion = $("input[name='descripcion[]']").map(function(){return $(this).val();}).get();
            var preciounitario = $("input[name='preciounitario[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            let formData = new FormData();

            formData.append('condicion', condicion);
            formData.append('tipomaterial', tipomaterial);
            formData.append('proveedor', proveedor);
            formData.append('equipo', equipo);

            // solo con recorrer material es suficiente, por tener la misma cantidad de filas
            for(var a = 0; a < material.length; a++){
                formData.append('material[]', material[a]);
                formData.append('descripcion[]', descripcion[a]);

                formData.append('preciounitario[]', preciounitario[a]);
                formData.append('cantidad[]', cantidad[a]);
            }

            // ingresar los ID de todos los select array
            // todos los select tienen una clase con nombre seleccion
            // asi que recorre todos para obtener su id
            var row = $('table').find('tr');
            $(row).each(function (index, element) {
                var unidad = $(this).find('.seleccion').val();

                if(unidad !== undefined && unidad != null){
                    formData.append('unidadmedida[]', unidad);
                }
            });

            axios.post('/admin1/bodega/registrar/material', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        // nombre de un material no se encontro
                        alertaMensaje('warning','No encontrado','En la fila "'+(response.data.fila)+'". El material con nombre: "'+(response.data.nombre)+'" \n No se encuentra Registrado');
                    }
                    else if(response.data.success == 2){
                        // registrado correctamente
                        toastMensaje('success', 'Registrado');
                        borrarTabla();
                    }
                    else{
                        toastMensaje('error', 'Error al Registrar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al Registrar');
                });
        }

        // borrar todas las filas e ingresar una en blanco
        function borrarTabla(){
            $("#matriz tbody tr").remove();

            var nFilas = $('#matriz >tbody >tr').length;
            nFilas += 1;

            //agrega las filas dinamicamente

            var markup = "<tr id='"+(nFilas)+"'>"+

                "<td>"+
                "<p id='fila"+(nFilas)+"' class='form-control' style='max-width: 65px'>"+(nFilas)+"</p>"+
                "</td>"+

                "<td>"+
                "<input name='material[]' maxlength='300' id='material"+(nFilas)+"' onkeydown='buscarNombre(this.id)' class='form-control' type='text' value=''>"+
                "</td>"+

                "<td>"+
                "<input name='descripcion[]' maxlength='300' class='form-control' type='text' value=''>"+
                "</td>"+

                "<td>"+
                "<select class='form-control seleccion' style='max-width: 110px' name='unidadmedida[]'"+
                "<option value='0'>Seleccionar Unidad</option>"+
                "@foreach($unidad as $data)"+
                "<option value='{{ $data->id }}'>{{ $data->nombre }}</option>"+
                "@endforeach>"+
                "</select>"+
                "</td>"+

                "<td>"+
                "<input name='cantidad[]' class='form-control' style='max-width: 85px' type='number' step='1' value=''/>"+
                "</td>"+

                "<td>"+
                "<input name='preciounitario[]' class='form-control' type='number' step='.01' style='max-width: 105px' value=''/>"+
                "</td>"+

                "<td>"+
                "<button type='button' class='btn btn-block btn-danger' onclick='borrarFila(this)'>Borrar</button>"+
                "</td>"+

                "</tr>";

            $("tbody").append(markup);
        }

        // alerta personalizada
        function alertaMensaje(tipo, titulo, mensaje){

            Swal.fire({
                title: titulo,
                text: mensaje,
                icon: tipo,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            })
        }

        function borrarFila(elemento){
            var tabla = elemento.parentNode.parentNode;
            tabla.parentNode.removeChild(tabla);
            setearFila();
        }

        // cambiar # de fila cada vez que se borre una fila
        function setearFila(){

            var table = document.getElementById('matriz');
            var conteo = 0;
            for (var r = 1, n = table.rows.length; r < n; r++) {
                conteo +=1;
                var element = table.rows[r].cells[0].children[0];
                document.getElementById(element.id).innerHTML = ""+conteo;
            }
        }


    </script>



@stop
