@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista de Ventas</h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('ventas.create') }}" class="btn btn-success btn-sm">
                                <i class="glyphicon glyphicon-plus"></i> Nueva Venta
                            </a>
                        </div>
                        <div class="table-container">
                            <table id="mytable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Venta</th>
                                        <th>Cliente</th>
                                        <th>Fecha de Emisión</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($ventas->count())
                                        @foreach ($ventas as $venta)
                                            <tr>
                                                <td>{{ $venta->id_ven }}</td>
                                                <td>{{ $venta->nombre_cli_ven }}</td>
                                                <td>{{ $venta->fecha_emision_ven }}</td>
                                                <td>
                                                    <a href="javascript:void(0);" 
                                                       class="btn btn-info btn-sm"
                                                       onclick="toggleDetalles('detalles-{{ $venta->id_ven }}')">
                                                       <i class="glyphicon glyphicon-eye-open"></i> Detalles
                                                    </a>
                                                    {{-- <a href="{{ route('ventas.edit', $venta->id_ven) }}"
                                                       class="btn btn-warning btn-sm">
                                                       <i class="glyphicon glyphicon-pencil"></i> Editar
                                                    </a> --}}
                                                    <form action="{{ route('ventas.destroy', $venta->id_ven) }}"
                                                          method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">
                                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Detalles ocultos de la venta -->
                                            <tr id="detalles-{{ $venta->id_ven }}" style="display:none;">
                                                <td colspan="4">
                                                    <strong>Detalles de la Venta:</strong>
                                                    <ul>
                                                        @foreach ($venta->detalles as $detalle)
                                                            <li>
                                                                <strong>Producto:</strong> {{ $detalle->nombre_producto_detven }} |
                                                                <strong>Cantidad:</strong> {{ $detalle->cantidad_pro_detven }} |
                                                                <strong>Precio:</strong> ${{ number_format($detalle->precio_unitario_detven, 2) }} |
                                                                <strong>IVA:</strong> {{ $detalle->iva_detven }}%
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center">
                        {{ $ventas->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Función para mostrar/ocultar los detalles de la venta
        function toggleDetalles(id) {
            var detalles = document.getElementById(id);
            if (detalles.style.display === "none" || detalles.style.display === "") {
                detalles.style.display = "table-row";
            } else {
                detalles.style.display = "none";
            }
        }
    </script>
@endsection
@endsection
