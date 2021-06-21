@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />

@stop

<style>

    .total{
        font-family: Arial;
        font-size: 18px;
        margin-left: 30px;
    }

</style>

<section class="content-header">
    <div class="container-fluid">

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
                    <h3 class="card-title">Informes de Bodega</h3>
                </div>

                <div class="row" style="margin: 30px">

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Invertido en Bodega</span>
                                <span class="info-box-number">${{ $sumaIngreso }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Materiales en Bodega</span>
                                <span class="info-box-number">{{ $totalActual }}</span>
                            </div>
                        </div>
                    </div>




                    <div class="card-body" style="margin-top: 20px">
                        <hr>
                        <label>Total de ingresos por fecha</label>
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

                        <div class="row">
                            <button type="button" onclick="buscar()" class="btn btn-success btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                                Buscar
                            </button>

                            <p class="total" id="total"></p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


    <script>

        function buscar(){
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

            openLoading();
            let formData = new FormData();
            formData.append('desde', fechadesde);
            formData.append('hasta', fechahasta);

            axios.post('/admin1/informes/bodega1/ingresos-fechas', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Verificado');
                        document.getElementById('total').innerHTML = "El Total es: $ " + response.data.total;
                    }else{
                        toastMensaje('error', 'Error');
                    }
                })
                .catch((error) => {
                    toastMensaje('error', 'Error');
                });
        }

    </script>

@stop
