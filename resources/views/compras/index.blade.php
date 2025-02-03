@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Compras</h3>
                    </div>
                    <div class="panel-body">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('compras.create') }}" class="btn btn-success">Añadir Compra</a>
                        </div>
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Compra</th>
                                        <th>Proveedor</th>
                                        <th>Fecha de Emisión</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($compras->count())
                                        @foreach ($compras as $compra)
                                            @php
                                                $totalCompra = $compra->detalles->sum(function ($detalle) {
                                                    return $detalle->cantidad_pro_detcom * $detalle->precio_unitario_detcom * (1 + $detalle->iva_detcom / 100);
                                                });
                                            @endphp
                                            <tr>
                                                <td>{{ $compra->id_com }}</td>
                                                <td>{{ $compra->nombre_proveedor_com }}</td>
                                                <td>{{ $compra->fecha_emision_com }}</td>
                                                <td>${{ number_format($totalCompra, 2) }}</td>
                                                <td>
                                                    <!-- Botones de acciones -->
                                                    <a href="#" class="btn btn-primary btn-sm"
                                                       onclick="toggleDetalles('detalles-{{ $compra->id_com }}')">
                                                        <i class="glyphicon glyphicon-eye-open"></i> Detalles
                                                    </a>
                                                    <a href="{{ route('compras.edit', $compra->id_com) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="glyphicon glyphicon-pencil"></i> Editar
                                                    </a>
                                                    <form action="{{ route('compras.destroy', $compra->id_com) }}"
                                                          method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta compra?');">
                                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- Fila oculta con detalles de la compra -->
                                            <tr id="detalles-{{ $compra->id_com }}" style="display:none;">
                                                <td colspan="5">
                                                    <strong>Detalles de la Compra:</strong>
                                                    <ul>
                                                        @foreach ($compra->detalles as $detalle)
                                                            <li><strong>ID Detalle:</strong> {{ $detalle->id_detcom }}</li>
                                                            <li><strong>Producto:</strong> {{ $detalle->producto->nombre_pro }}</li>
                                                            <li><strong>Descripción:</strong> {{ $detalle->producto->descripcion_pro }}</li>
                                                            <li><strong>Cantidad:</strong> {{ $detalle->cantidad_pro_detcom }}</li>
                                                            <li><strong>Precio Unitario:</strong> ${{ number_format($detalle->precio_unitario_detcom, 2) }}</li>
                                                            <li><strong>IVA:</strong> {{ $detalle->iva_detcom }}%</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $compras->links() }}
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Función para mostrar u ocultar los detalles de la compra
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
