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

                            <div class="form-group row" style="margin-top: 30px; margin-left: 3px">
                                <label class="control-label">Notas: </label>
                                <div class="col-sm-5" style="margin-left: 18px">
                                    <input id="nota" maxlength="800" class="form-control" type="text" value="">
                                </div>
                            </div>

                            <table class="table" id="matriz"  data-toggle="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Cantidad</th>

                                    <th scope="col">Opciones</th>
                                </tr>
                                </thead>
                                <tbody id="myTbody">

                                <tr id="0">
                                    <td><p name="fila[]" disabled id="fila0" class="form-control" style="max-width: 65px">1</td>
                                    <td><input name="material[]" id="material0" onkeydown="buscarNombre(this.id)" maxlength="300" class="form-control" type="text" value="" autocomplete="off"></td>
                                    <td><input name="descripcion[]" maxlength="500" class="form-control" type="text" value=""></td>
                                    <td><input name="cantidad[]" class="form-control" type="number" step="1" style="max-width: 85px" ></td>
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

        // busca el nombre del material
        function buscarNombre(value){
            $('#'+(value)+'').autocomplete({
                source: function(request, response){

                    axios.post(url+'/sistema4/bodega/buscar/material', {
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
                    "<input name='descripcion[]' maxlength='500' class='form-control' type='text' value=''>"+
                    "</td>"+


                    "<td>"+
                    "<input name='cantidad[]' class='form-control' style='max-width: 85px' type='number' step='1' value=''/>"+
                    "</td>"+

                    "<td>"+
                    "<button type='button' class='btn btn-block btn-danger' onclick='borrarFila(this)'>Borrar</button>"+
                    "</td>"+

                    "</tr>";

                $("tbody").append(markup);

            });
        });

        function verificar(){

            Swal.fire({
                title: 'Guardar Retiro?',
                text: "",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Guardar'
            }).then((result) => {
                if (result.isConfirmed) {
                    verificarRes();
                }
            })

        }

        // verificar que todos los datos a ingresar sean correctos
        function verificarRes(){

            // minimo se necesitara 1 registro para guardar
            var nRegistro = $('#matriz >tbody >tr').length;
            if (nRegistro <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo');
                return;
            }

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var descripcion = $("input[name='descripcion[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

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
                    if(datoDescripcion.length > 500) {
                        alertaMensaje('warning','Inválido', 'En la fila "' + (b+1) + '", los caracteres máximo son 500 y ha ingresado: "'+datoDescripcion.length+'"')
                        return;
                    }
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
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es valida. \n \n Números validos del 1 en adelante')
                    return;
                }

                if(datoCantidad <= 0){
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida, debe ser mayor a 0')
                    return;
                }
            }

            guardarRegistro();
        }

        function guardarRegistro(){

            openLoading();

            // verificar los primeros campos select
            var nota = document.getElementById('nota').value;

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var descripcion = $("input[name='descripcion[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            let formData = new FormData();

            formData.append('nota', nota);

            for(var a = 0; a < material.length; a++){
                formData.append('material[]', material[a]);
                formData.append('descripcion[]', descripcion[a]);
                formData.append('cantidad[]', cantidad[a]);
            }

            axios.post(url+'/sistema4/retiro/bodega/material', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        // material no encontrado
                        alertaMensaje('warning','No encontrado','En la fila "'+(response.data.fila)+'". El material con nombre: "'+(response.data.nombre)+'" \n No se encuentra Registrado');

                    }
                    else if(response.data.success === 2){
                        // no hay unidades suficientes para el retiro
                        alertaMensaje('warning','Sin Unidades','En la fila "'+(response.data.fila)+'". El material con nombre: "'+(response.data.nombre)+'" \n supera a las unidades disponible: ' +
                            '"'+(response.data.total)+'". \n Verificar que este material a retirar no supere las unidades disponibles');
                    }
                    else if(response.data.success === 3){
                        // registrado el retiro correctamente
                        toastMensaje('success', 'Retirado correctamente');
                        borrarTabla();
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
                "<input name='descripcion[]' maxlength='500' class='form-control' type='text' value=''>"+
                "</td>"+


                "<td>"+
                "<input name='cantidad[]' class='form-control' style='max-width: 85px' type='number' step='1' value=''/>"+
                "</td>"+


                "<td>"+
                "<button type='button' class='btn btn-block btn-danger' onclick='borrarFila(this)'>Borrar</button>"+
                "</td>"+

                "</tr>";

            $("tbody").append(markup);
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
