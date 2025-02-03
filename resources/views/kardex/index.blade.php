@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista de Kardex</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('kardex.create') }}" class="btn btn-info">Añadir Kardex</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Kardex</th>
                                        <th>Código Producto</th>
                                        <th>Nombre Producto</th>
                                        <th>Stock</th>
                                        <th>Mínimo</th>
                                        <th>Máximo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($kardex->count())
                                        @foreach ($kardex as $item)
                                            <tr>
                                                <td>{{ $item->id_kar }}</td>
                                                <td>{{ $item->codigo_pro }}</td>
                                                <td>{{ $item->producto ? $item->producto->nombre_pro : 'Sin asignar' }}</td>
                                                <td>{{ $item->stock_kar }}</td>
                                                <td>{{ $item->minimo_kar }}</td>
                                                <td>{{ $item->maximo_kar }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="toggleDetalles('detalles-{{ $item->id_kar }}')">Detalles</button>
                                                    <a href="{{ route('kardex.edit', $item->id_kar) }}"
                                                        class="btn btn-warning btn-sm">Editar</a>
                                                    <form action="{{ route('kardex.destroy', $item->id_kar) }}"
                                                        method="POST" style="display:inline-block;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este registro de kardex?');">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Fila oculta con detalles -->
                                            <tr id="detalles-{{ $item->id_kar }}" style="display:none;">
                                                <td colspan="7">
                                                    <strong>Detalles del Kardex:</strong>
                                                    <ul>
                                                        <li><strong>ID Kardex:</strong> {{ $item->id_kar }}</li>
                                                        <li><strong>Nombre Producto:</strong>
                                                            {{ $item->producto ? $item->producto->nombre_pro : 'Sin asignar' }}
                                                        </li>
                                                        <li><strong>Descripción Producto:</strong>
                                                            {{ $item->producto ? $item->producto->descripcion_pro : 'No disponible' }}
                                                        </li>
                                                    
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $kardex->links() }}
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Función para mostrar u ocultar los detalles del kardex
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
