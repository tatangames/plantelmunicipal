@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-select.min.css') }}" type="text/css" rel="stylesheet" />
@stop

<section class="content-header">

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Reporte Detalles Equipo</h3>
        </div>
        <div class="card-body">
            <label>Reporte General</label>
            <br>
            <div class="form-group">
                <div class="form-inline">
                    <label class="control-label">Fecha De: </label>
                    <input type="date" id="fecha-de" class="form-control" style="width: 17%; margin-left: 20px;">
                    &nbsp;&nbsp;
                    <label class="control-label" style="margin-left: 15px">Fecha Hasta: </label>
                    <input type="date" id="fecha-hasta" class="form-control" style="margin-left: 15px; width: 17%;">

                </div>
            </div>

            <br>

        </div>
        <div class="card-footer">
            <button type="button"  class="btn btn-success" onclick="verificar();">Generar Reporte</button>
        </div>

        <hr>
        <div class="card-body">

            <label>Reporte por Equipo</label>
            <br>

            <div class="form-group">
                <div class="form-inline">
                    <label class="control-label">Fecha De: </label>
                    <input type="date" id="fecha-de2" class="form-control" style="width: 17%; margin-left: 20px;">
                    &nbsp;&nbsp;
                    <label class="control-label" style="margin-left: 15px">Fecha Hasta: </label>
                    <input type="date" id="fecha-hasta2" class="form-control" style="margin-left: 15px; width: 17%;">

                </div>
            </div>

            <br>

            <div class="form-group row" style="margin-top: 30px">
                <label class="control-label">Equipo: </label>
                <div class="col-sm-5" style="margin-left: 10px">
                    <select id="select-equipo" class="form-control selectpicker" data-live-search="true">
                        @foreach($equipo as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="button"  class="btn btn-success" onclick="verificar2();">Generar Reporte</button>
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

    <script>

        function verificar(){

            var fechadesde = document.getElementById('fecha-de').value;
            var fechahasta = document.getElementById('fecha-hasta').value;

            if(fechadesde === ''){
                toastMensaje('error', 'Fecha Desde es Requerido');
                return;
            }

            if(fechahasta === ''){
                toastMensaje('error', 'Fecha Hasta es Requerido');
                return;
            }

            window.open("{{ URL::to('sistema2/reportes/bodega2/ingreso') }}/" + fechadesde + "/" + fechahasta);
        }

        function verificar2(){

            var fechadesde = document.getElementById('fecha-de2').value;
            var fechahasta = document.getElementById('fecha-hasta2').value;
            var equipo = document.getElementById('select-equipo').value;

            if(fechadesde === ''){
                toastMensaje('error', 'Fecha Desde es Requerido');
                return;
            }

            if(fechahasta === ''){
                toastMensaje('error', 'Fecha Hasta es Requerido');
                return;
            }

            window.open("{{ URL::to('sistema2/reportes2/bodega2/ingreso') }}/" + fechadesde + "/" + fechahasta + "/" + equipo);
        }


    </script>

@stop

