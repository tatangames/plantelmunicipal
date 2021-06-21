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
                                <th>Nombre Empresa</th>
                                <th>Contácto</th>
                                <th>Teléfono Fijo</th>
                                <th>Teléfono Móvil</th>
                                <th>Observaciones</th>

                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($listado as $dato)
                                <tr>

                                    <td>{{ $dato->empresa }}</td>
                                    <td>{{ $dato->nombrecontacto }}</td>
                                    <td>{{ $dato->telfijo }}</td>
                                    <td>{{ $dato->telmovil }}</td>
                                    <td>{{ $dato->observaciones }}</td>

                                    <td>
                                        <button type="button" class="btn btn-success btn-xs" onclick="verInformacion({{ $dato->id }})">
                                            <i class="fas fa-eye" title="Ver"></i>&nbsp; Ver
                                        </button>
                                        @can('boton.grupo.bodega1.proveedores.listado.btn-editar')
                                        <button type="button" class="btn btn-primary btn-xs" onclick="verInformacionEditar({{ $dato->id }})">
                                            <i class="fas fa-pencil-alt" title="Editar"></i>&nbsp; Editar
                                        </button>
                                        @endcan
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
                    filename: 'Tabla Proveedores',
                    title: '',
                    sheetName: 'Proveedores',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4],
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
