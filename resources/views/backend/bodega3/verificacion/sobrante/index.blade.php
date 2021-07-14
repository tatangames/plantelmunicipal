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
                        <h3 class="card-title">Materiales Existencia</h3>
                    </div>
                    <form>
                        <div class="card-body">

                            <table class="table" id="matriz"  data-toggle="table">
                                <thead>
                                <tr>
                                    <th scope="col" style="max-width: 50px">Fecha</th>
                                    <th scope="col" style="max-width: 50px">Descripción</th>
                                    <th scope="col" style="max-width: 15px">Existencia Inicial</th>
                                    <th scope="col" style="max-width: 15px">Existencia Verificada</th>
                                    <th scope="col" style="max-width: 15px">Existencia Retirada</th>
                                    <th scope="col" style="max-width: 15px">Existencia Final</th>
                                </tr>
                                </thead>
                                <tbody id="myTbody">

                                @foreach($dataArray as $dato)

                                    <tr>
                                        <td style="max-width: 10px">
                                            <input disabled class="form-control" type="text" value="{{ $dato['fecha'] }}">
                                        </td>
                                        <td style="max-width: 75px">
                                            <input disabled class="form-control" type="text" value="{{ $dato['nombre'] }}">
                                        </td>
                                        <td style="max-width: 15px"><input disabled class="form-control" value="{{ $dato['cantidad'] }}"></td>

                                        <td style="max-width: 15px"><input disabled class="form-control" value="{{ $dato['cantiverificada'] }}"></td>
                                        <td style="max-width: 15px"><input disabled class="form-control" value="{{ $dato['cantiretirada'] }}"></td>
                                        <td style="max-width: 15px"><input disabled class="form-control" value="{{ $dato['sobrante'] }}"></td>
                                    </tr>

                                @endforeach

                                </tbody>

                            </table>
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



@stop
