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
                                <span class="info-box-number">${{ $sumaPrecio }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Llantas en Bodega</span>
                                <span class="info-box-number">{{ $totalActual }}</span>
                            </div>
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




@stop
