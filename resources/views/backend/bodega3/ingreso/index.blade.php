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
            <div class="col-md-10">
                <div class="card card-green">
                    <div class="card-header">
                        <h3 class="card-title">Detalle</h3>
                    </div>
                    <form>
                        <div class="card-body">

                            <div class="form-group row" style="margin-top: 30px">
                                <label class="control-label" style="margin-left: 15px">Tipo de Proyecto: </label>
                                <div class="col-sm-8" style="margin-left: 15px">
                                    <select id="select-servicio" class="form-control selectpicker" data-live-search="true">
                                        @foreach($servicio as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label" style="margin-left: 15px">Proyecto: </label>
                                <div class="col-sm-8" style="margin-left: 15px">
                                    <input type="text" maxlength="800" placeholder="Nombre del Proyecto" class="form-control" id="nombre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label" style="margin-left: 15px">Destino: </label>
                                <div class="col-sm-8" style="margin-left: 18px">
                                    <input type="text" maxlength="800" placeholder="Destino del Proyecto" class="form-control" id="destino">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label" style="margin-left: 15px">Código: </label>
                                <div class="col-sm-8" style="margin-left: 22px">
                                    <input type="text" maxlength="150" class="form-control" id="codigo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label" style="margin-left: 15px">Nota: </label>
                                <div class="col-sm-8" style="margin-left: 38px">
                                    <input type="text" maxlength="300" class="form-control" id="nota">
                                </div>
                            </div>

                            <br>
                            <div class="col-sm-10" style=" border-style: solid; border-color: #808080;">

                                <div class="form-group row">
                                    <label class="control-label" style="margin-left: 5px">Documento: </label>
                                    <div class="col-sm-6" style="margin-left: 10px">
                                        <input type="file" class="form-control" id="documento" accept="application/pdf" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label" style="margin-left: 5px">Nombre para Documento</label>
                                    <div class="col-sm-8" style="margin-left: 22px">
                                        <input type="text" maxlength="100" class="form-control" id="nombredoc">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <hr>

        <div class="row">
            <div class="col-md-10">
                <div class="card card-green">
                    <div class="card-header">
                        <h3 class="card-title">Encargados</h3>
                    </div>

                    <table class="table" id="matrizEncargado"  data-toggle="table">
                        <thead>
                        <tr>
                            <th scope="col">Cargo</th>
                            <th scope="col">Persona</th>

                            <th scope="col">Opciones</th>
                        </tr>
                        </thead>
                        <tbody id="myTbodyEncargado">

                        <tr id="0">
                            <td>
                                <select name="cargo[]" class="form-control seleccionCargo" style="max-width: 300px">
                                    @foreach($cargo as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="persona[]" class="form-control seleccionPersona" style="max-width: 350px">
                                    @foreach($persona as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <button type="button" class="btn btn-block btn-danger" id="btnBorrarEncargado" onclick="borrarFilaEncargado(this)">Borrar</button>
                            </td>
                        </tr>

                        </tbody>

                    </table>

                    <br>
                    <button type="button" class="btn btn-block btn-success" id="btnAddEncargado">Agregar Fila</button>


                </div>
            </div>
        </div>

        <br>

        <hr>


        <div class="row">
            <div class="col-md-10">
                <div class="card card-green">
                    <div class="card-header">
                        <h3 class="card-title">Materiales</h3>
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


        //*** TABLA ENCARGADOS

        // agregar fila a tabla encargados
        $(document).ready(function () {
            $("#btnAddEncargado").on("click", function () {

                var nFilas = $('#matrizEncargado >tbody >tr').length;
                nFilas += 1;

                //agrega las filas dinamicamente

                var markup = "<tr id='"+(nFilas)+"'>"+

                    "<td>"+
                    "<select class='form-control seleccionCargo' style='max-width: 300px' name='cargo[]'"+
                    "<option value='0'>Seleccionar Cargo</option>"+
                    "@foreach($cargo as $data)"+
                    "<option value='{{ $data->id }}'>{{ $data->nombre }}</option>"+
                    "@endforeach>"+
                    "</select>"+
                    "</td>"+

                    "<td>"+
                    "<select class='form-control seleccionPersona' style='max-width: 350px' name='persona[]'"+
                    "<option value='0'>Seleccionar Encargado</option>"+
                    "@foreach($persona as $data)"+
                    "<option value='{{ $data->id }}'>{{ $data->nombre }}</option>"+
                    "@endforeach>"+
                    "</select>"+
                    "</td>"+

                    "<td>"+
                    "<button type='button' class='btn btn-block btn-danger' onclick='borrarFilaEncargado(this)'>Borrar</button>"+
                    "</td>"+

                    "</tr>";

                $("#matrizEncargado tbody").append(markup);

            });
        });

        // borrar tabla fila encargados
        function borrarFilaEncargado(elemento){
            var tabla = elemento.parentNode.parentNode;
            tabla.parentNode.removeChild(tabla);
        }

        // agregar tabla defecto cuando se completa un ingreso
        function borrarTablaEncargado(){
            $("#matrizEncargado tbody tr").remove();

            var nFilas = $('#matrizEncargado >tbody >tr').length;
            nFilas += 1;

            //agrega las filas dinamicamente

            var markup = "<tr id='"+(nFilas)+"'>"+

                "<td>"+
                "<select class='form-control seleccionCargo' style='max-width: 300px' name='cargo[]'"+
                "<option value='0'>Seleccionar Cargo</option>"+
                "@foreach($cargo as $data)"+
                "<option value='{{ $data->id }}'>{{ $data->nombre }}</option>"+
                "@endforeach>"+
                "</select>"+
                "</td>"+

                "<td>"+
                "<select class='form-control seleccionPersona' style='max-width: 350px' name='persona[]'"+
                "<option value='0'>Seleccionar Encargado</option>"+
                "@foreach($persona as $data)"+
                "<option value='{{ $data->id }}'>{{ $data->nombre }}</option>"+
                "@endforeach>"+
                "</select>"+
                "</td>"+

                "<td>"+
                "<button type='button' class='btn btn-block btn-danger' onclick='borrarFilaEncargado(this)'>Borrar</button>"+
                "</td>"+

                "</tr>";

            $("#matrizEncargado tbody").append(markup);
        }


        //*** VERIFICACION DE DATOS

        function preguntaverificar(){

            Swal.fire({
                title: 'Registrar Ingreso?',
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

            // minimo se necesitara 1 registro para encargados
            var nRegistro = $('#matrizEncargado >tbody >tr').length;
            if (nRegistro <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo para Encargados');
                return;
            }

            // minimo se necesitara 1 registro para materiales
            var nRegistroM = $('#matrizMateriales >tbody >tr').length;
            if (nRegistroM <= 0){
                alertaMensaje('warning','Registros Requerido','Se debe ingresar 1 registro como mínimo para Materiales');
                return;
            }

            var destino = document.getElementById('destino').value;
            var nombre = document.getElementById('nombre').value;
            var codigo = document.getElementById('codigo').value;
            var nota = document.getElementById('nota').value;
            var nombredoc = document.getElementById('nombredoc').value;

            var doc = document.getElementById('documento');

            if(doc.files && doc.files[0]){ // si trae documento
                if (!doc.files[0].type.match('application/pdf')){
                    alertaMensaje('warning','Inválido', 'Formato permitido: .pdf');
                    return false;
                }
            }

            // revisiones

            if(nombre === ''){
                alertaMensaje('warning','Requerido', 'Nombre para el Servicio es Requerido');
                return;
            }

            if(nombre.length > 800){
                alertaMensaje('warning','Inválido', 'Máximo 800 caracteres para Nombre');
                return;
            }

            if(destino.length > 800){
                alertaMensaje('warning','Inválido', 'Máximo 800 caracteres para Destino');
                return;
            }

            if(codigo.length > 150){
                alertaMensaje('warning','Inválido', 'Máximo 150 caracteres para Código');
                return;
            }

            if(nota.length > 300){
                alertaMensaje('warning','Inválido', 'Máximo 300 caracteres para Nota');
                return;
            }

            if(nombredoc.length > 100){
                alertaMensaje('warning','Inválido', 'Máximo 100 caracteres para Nombre Documento');
                return;
            }

            // verificar que hay al menos 1 encargado (ya que se pueden desactivar)

            var bloqueo = 0;

            $("#matrizEncargado tr").each(function(){
                var persona = $(this).find('.seleccionPersona').val();

                if(persona !== undefined && persona != null){
                   bloqueo++;
                }
            });

            if(bloqueo === 0){
                alertaMensaje('warning','Inválido', 'Se necesita 1 Persona Encargada');
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
                    alertaMensaje('warning','Inválido', 'En la fila "' + (d+1) + '", la Cantidad no es válida.')
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

            var servicio = document.getElementById('select-servicio').value;
            var nombre = document.getElementById('nombre').value;
            var destino = document.getElementById('destino').value;
            var codigo = document.getElementById('codigo').value;
            var nota = document.getElementById('nota').value;
            var nombredoc = document.getElementById('nombredoc').value;
            var documento = document.getElementById("documento");

            let formData = new FormData();

            formData.append('servicio', servicio);
            formData.append('nombre', nombre);
            formData.append('codigo', codigo);
            formData.append('nota', nota);
            formData.append('destino', destino);
            formData.append('nombredoc', nombredoc);
            formData.append('documento', documento.files[0]);

            // encargados

            $("#matrizEncargado tr").each(function(){
                var cargo = $(this).find('.seleccionCargo').val();
                var persona = $(this).find('.seleccionPersona').val();

                if(cargo !== undefined && cargo != null){
                    formData.append('cargo[]', cargo);
                }

                if(persona !== undefined && persona != null){
                    formData.append('persona[]', persona);
                }
            });

            var material = $("input[name='material[]']").map(function(){return $(this).val();}).get();
            var preciounitario = $("input[name='preciounitario[]']").map(function(){return $(this).val();}).get();
            var cantidad = $("input[name='cantidad[]']").map(function(){return $(this).val();}).get();

            for(var a = 0; a < material.length; a++){
                formData.append('material[]', material[a]);
                formData.append('preciounitario[]', preciounitario[a]);
                formData.append('cantidad[]', cantidad[a]);
            }

            axios.post(url+'/sistema3/bodega3/registro', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        // registrado correctamente
                        toastMensaje('success', 'Registrado');
                        document.getElementById("nombre").value = "";
                        document.getElementById("destino").value = "";
                        document.getElementById("codigo").value = "";
                        document.getElementById("nota").value = "";
                        document.getElementById("nombredoc").value = "";
                        document.getElementById("documento").value = "";


                        borrarTablaEncargado();
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
