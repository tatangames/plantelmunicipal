<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tipo de Llanta</th>
                                <th>Descripción</th>
                                <th>Cantidad Disponible</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listado as $ll)
                                <tr>
                                    <td>{{ $ll->nombre }}</td>
                                    <td>{{ $ll->codigo }}</td>
                                    <td>{{ $ll->cantidad }}</td>

                                    <td>
                                        @can('vista.grupo.bodega4.registros.registro-de-bodega.boton-editar')
                                        <button type="button" class="btn btn-primary btn-xs" onclick="modalInformacion({{ $ll->id }})">
                                            <i class="fas fa-edit" title="Editar"></i> Editar
                                        </button>
                                        <br>
                                        <br>
                                        @endcan
                                        <button type="button" class="btn btn-success btn-xs" onclick="historialIngreso({{ $ll->id }})">
                                            <i class="far fa-file" title="Historial Ingreso"></i> Historial Ingreso
                                        </button>
                                        <br>
                                        <br>
                                        <button type="button" class="btn btn-success btn-xs" onclick="historialRetiro({{ $ll->id }})">
                                            <i class="far fa-file" title="Historial Retiro"></i> Historial Retiro
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(function () {
        $("#tabla").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,

            "language": {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
    });

</script>

