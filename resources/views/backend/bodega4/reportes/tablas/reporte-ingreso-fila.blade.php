<html>
<head>
    <style>
        body{
            font-family: Arial;
        }
        @page {
            margin: 145px 25px;
            /* margin-bottom: 10%;*/
        }
        header { position: fixed;
            left: 0px;
            top: -160px;
            right: 0px;
            height: 100px;
            text-align: center;
            font-size: 12px;
        }
        header h1{
            margin: 10px 0;
        }
        header h2{
            margin: 0 0 10px 0;
        }
        footer {
            position: fixed;
            left: 0px;
            bottom: -10px;
            right: 0px;
            height: 10px;
            /* border-bottom: 2px solid #ddd;*/
        }

        footer table {
            width: 100%;
        }
        footer p {
            text-align: right;
        }
        footer .izq {
            margin-top: 20px; !important;
            margin-left: 20px;
            text-align: left;
        }

        .content {
            padding: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .content img {
            margin-right: 15px;
            float: right;
        }

        .content h3{
            font-size: 20px;

        }
        .content p{
            margin-left: 15px;
            display: block;
            margin: 2px 0 0 0;
        }

        hr{
            page-break-after: always;
            border: none;
            margin: 0;
            padding: 0;
        }

        #tabla {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 35px;
            text-align: center;
        }

        #tabla td{
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 15px;
        }

        #tabla th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }


        #tabla th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #f2f2f2;
            color: #1E1E1E;
            text-align: center;
            font-size: 16px;
        }

        .fecha{
            font-size: 16px;
            margin-left: 17px;
        }

    </style>
<body>
<header style="margin-top: 25px">
    <div class="row">

        <div class="content">
            <img src="{{ asset('images/logoalcaldiacolor.png') }}" style="float: right" alt="" height="88px" width="72px">
            <h3>REPORTE INGRESOS</h3>
            <p style="font-size: 17px">Fecha desde: {{ $f1 }} Hasta: {{ $f2 }}</p>
        </div>

    </div>
</header>

<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Marco Tulio<br>
                    Encargado de Bodega
                </p>
            </td>
            <td>
                <p class="page">

                </p>
            </td>
        </tr>
    </table>
</footer>

<div id="content">

    <table id="tabla">
        <thead>
        <tr>
            <th style="text-align: center; width: 11%">Fecha</th>
            <th style="text-align: center; width: 13%">Tipo Llanta</th>
            <th style="text-align: center; width: 25%">Descripción</th>
            <th style="text-align: center; width: 11%">Cantidad</th>
            <th style="text-align: center; width: 10%">P.U</th>
            <th style="text-align: center; width: 10%">Total</th>
        </tr>
        </thead>

        @foreach($dataArray as $dato)
            <tr>
                <td>{{ $dato['fecha'] }}</td>
                <td>{{ $dato['nombre'] }}</td>
                <td>{{ $dato['descripcion'] }}</td>
                <td>{{ $dato['cantidad'] }}</td>
                <td>$ {{ $dato['preciounitario'] }}</td>
                <td>$ {{ $dato['totalmultiplicado'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>$ {{ $sumatoria }}</td>
        </tr>

    </table>





</div>




<script type="text/php">
    if (isset($pdf)) {
        $x = 485;
        $y = 720;
        $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>

</body>
</html>
