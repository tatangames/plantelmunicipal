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
        <h1>Agregar Materiales</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid" >

        <div class="row">
            <div class="col-md-10">
                <div class="card card-green">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Materiales</h3>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Nota</label>
                        <input type="text" maxlength="500" class="form-control" id="nota">
                    </div>

                    <table class="table" id="matrizMateriales"  data-toggle="table">
                        <thead>
                        <tr>

                            <th scope="col">#</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio Unitario</th>

                            <th scope="col">Opciones</th>
                        </tr>
                        </thead>
                        <tbody id="myTbodyMateriales">

                        <tr id="0">
                            <td><p name="fila[]" disabled id="fila0" class="form-control" style="max-width: 65px">1</td>
                            <td><input name="material[]" id="material0" maxlength="300" class="form-control" type="text"></td>

                            <td><input name="cantidad[]" class="form-control" type="text" maxlength="8" style="max-width: 85px" ></td>
                            <td><input name="preciounitario[]" class="form-control" type="text" maxlength="8"  style="max-width: 105px" ></td>
                            <td><button type="button" class="btn btn-block btn-danger" id="btnBorrar" onclick="borrarFila(this)">Borrar</button></td>
                        </tr>

                        </tbody>

                    </table>

                    <br>
                    <button type="button" class="btn btn-block btn-success" id="btnAddMateriales">Agregar Fila</button>
                </div>
            </div>
        </div>

        <br>

        <div class="card-footer">
            <button type="button"  class="btn btn-primary float-right" onclick="preguntaverificar();">Guardar Registros</button>
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

        //*** TABLA MATERIALES

        $(document).ready(function () {
            $("#btnAddMateriales").on("click", function () {

                var nFilas = $('#matrizMateriales >tbody >tr').length;
                nFilas += 1;

                //agrega las filas dinamicamente

                var markup = "<tr id='"+(nFilas)+"'>"+

                    "<td>"+
                    "<p id='fila"+(nFilas)+"' class='form-control' style='max-width: 65px'>"+(nFilas)+"</p>"+
                    "</td>"+

                    "<td>"+
                    "<input name='material[]' id='material"+(nFilas)+"' maxlength='300' class='form-control' type='text' value=''>"+
                    "</td>"+

                    "<td>"+
                    "<input name='cantidad[]' class='form-control' style='max-width: 85px' type='text' maxlength='8' value=''/>"+
                    "</td>"+

                    "<td>"+
                    "<input name='preciounitario[]' class='form-control' style='max-width: 105px' type='text' maxlength='8' value=''/>"+
                    "</td>"+

                    "<td>"+
                    "<button type='button' class='btn btn-block btn-danger' onclick='borrarFila(this)'>Borrar</button>"+
                    "</td>"+

                    "</tr>";

                $("#matrizMateriales tbody").append(markup);

            });
        });



        // borrar todas las filas e ingresar una en blanco
        function borrarTabla(){
            $("#matrizMateriales tbody tr").remove();

            var nFilas = $('#matrizMateriales >tbody >tr').length;
            nFilas += 1;

            //agrega las filas dinamicamente

            var markup = "<tr id='"+(nFilas)+"'>"+

                "<td>"+
                "<p id='fila"+(nFilas)+"' class='form-control' style='max-width: 65px'>"+(nFilas)+"</p>"+
                "</td>"+

                "<td>"+
                "<input name='material[]' maxlength='300' id='material"+(nFilas)+"' class='form-control' type='text' value=''>"+
                "</td>"+

                "<td>"+
                "<input name='cantidad[]' class='form-control' style='max-width: 85px' type='text' maxlength='8' value=''/>"+
                "</td>"+

                "<td>"+
                "<input name='preciounitario[]' class='form-control' style='max-width: 105px' type='text' maxlength='8' value=''/>"+
                "</td>"+

                "<td>"+
                "<button type='button' class='btn btn-block btn-danger' onclick='borrarFila(this)'>Borrar</button>"+
                "</td>"+

                "</tr>";

            $("#matrizMateriales tbody").append(markup);
        }


        function borrarFila(elemento){
            var tabla = elemento.parentNode.parentNode;
            tabla.parentNode.removeChild(tabla);
            setearFila();
        }

        // cambiar # de fila cada vez que se borre una fila
        function setearFila(){
            var table = document.getElementById('matrizMateriales');
            var conteo = 0;
            for (var r = 1, n = table.rows.length; r < n; r++) {
                conteo +=1;
                var element = table.rows[r].cells[0].children[0];
                document.getElementById(element.id).innerHTML = ""+conteo;
            }
        }

        //*** VERIFICACION DE DATOS

        function preguntaverificar(){

            Swal.fire({
                title: 'Registrar Nuevos Materiales?',
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

            var nota = document.getElementById('nota').value;

            if(nota.length > 500){
                toastMensaje('error', '500 caracteres máximo para Nota');
                return;
            }

            // minimo se necesitara 1 registro para materiales
            var nRegistroM = $('#matrizMateriales >tbody >tr').length;
            if (nRegistroM <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo para Materiales');
                return;
            }

            // revisiones para materiales

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var preciounitario = $("input[name='preciounitario[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            var reglaNumeroEntero = /^[0-9]\d*$/;
            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;

            // verificar el campo Material
            for(var a = 0; a < material.length; a++){

                var datoMaterial = material[a];

                if(datoMaterial === ''){
                    alertaMensaje('warning','Campo Requerido','En la fila "'+(a+1)+'", se debe ingresar el Detalle');
                    return;
                }

                if(datoMaterial.length > 300) {
                    alertaMensaje('warning','Inválido', 'En la fila "' + (a+1) + '", los caracteres máximo son 300 y ha ingresado: "'+datoMaterial.length+'"')
                    return;
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

                // bloqueo 1 millon
                if(datoPrecioUnitario > 1000000){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (c+1) + '", Precio Unitario máximo es 1 millón')
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
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida. Solo números decimales')
                    return;
                }

                if(datoCantidad <= 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida, debe ser mayor a 0')
                    return;
                }

                // bloqueo 1 millon
                if(datoCantidad > 1000000){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad máxima es 1 millón')
                    return;
                }

            }

            guardarRegistro();
        }

        // guardado de registros del ingreso
        function guardarRegistro(){

            openLoading();

            let formData = new FormData();

            // id del ingreso_
            var id = {{ $id }};

            formData.append('id', id);

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var preciounitario = $("input[name='preciounitario[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            var nota = document.getElementById('nota').value;

            formData.append('nota', nota);

            for(var a = 0; a < material.length; a++){
                formData.append('material[]', material[a]);
                formData.append('preciounitario[]', preciounitario[a]);
                formData.append('cantidad[]', cantidad[a]);
            }

            axios.post(url+'/sistema3/bodega3/registro/extra-material', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        // registrado correctamente
                        toastMensaje('success', 'Registrado');
                        document.getElementById('nota').value = "";
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


    </script>



@stop
