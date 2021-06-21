<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Ubicación</th>
                                <th>Cantidad Disponible</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($listado as $ll)
                                <tr>
                                    <td>{{ $ll->nombre }}</td>
                                    <td>{{ $ll->codigo }}</td>
                                    <td>{{ $ll->ubicacion }}</td>
                                    <td>{{ $ll->cantidad }}</td>

                                    <td>
                                        @can('boton.grupo.bodega1.equipos.registrar-material.btn-editar')
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
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],

            buttons: [
                {
                    extend: 'excel',
                    text: 'Excel',
                    filename: 'Lista Materiales',
                    title: '',
                    sheetName: 'Materiales',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],

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

        }).buttons().container().appendTo('#tabla_wrapper .col-md-6:eq(0)');

    });

</script>
