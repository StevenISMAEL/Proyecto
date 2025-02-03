@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <!-- Tarjetas de métricas -->
        <div class="row text-center">
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #f0ad4e; color: #fff;">
                    <h3><i class="glyphicon glyphicon-list-alt"></i> Total Productos</h3>
                    <p style="font-size: 24px;">{{ $productos->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5bc0de; color: #fff;">
                    <h3><i class="glyphicon glyphicon-apple"></i> Productos Alimenticios</h3>
                    <p style="font-size: 24px;">{{ $productos->where('alimenticio_pro', true)->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5cb85c; color: #fff;">
                    <h3><i class="glyphicon glyphicon-usd"></i> Precio Promedio</h3>
                    <p style="font-size: 24px;">${{ number_format($productos->avg('precio_unitario_pro'), 2) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #d9534f; color: #fff;">
                    <h3><i class="glyphicon glyphicon-tag"></i> Último Producto</h3>
                    <p style="font-size: 24px;">{{ $productos->last()->nombre_pro ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Productos</h3>
                        <div class="pull-right">
                            <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm">
                                <i class="glyphicon glyphicon-plus"></i> Añadir Producto
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Precio Unitario</th>
                                        <th>Descripción del Producto</th>
                                        <th>¿Alimenticio?</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($productos->count())
                                        @foreach ($productos as $producto)
                                            <tr>
                                                <td>{{ $producto->codigo_pro }}</td>
                                                <td>{{ $producto->nombre_pro }}</td>
                                                <td>${{ number_format($producto->precio_unitario_pro, 2) }}</td>
                                                <td>{{ $producto->descripcion_pro }}</td>
                                                <td>{{ $producto->alimenticio_pro ? 'Sí' : 'No' }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm toggle-detalles"
                                                        data-target="detalles-{{ $producto->codigo_pro }}">
                                                        <i class="glyphicon glyphicon-eye-open"></i> Detalles
                                                    </button>
                                                    <a href="{{ route('productos.edit', $producto->codigo_pro) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="glyphicon glyphicon-pencil"></i> Editar
                                                    </a>
                                                    <form action="{{ route('productos.destroy', $producto->codigo_pro) }}"
                                                        method="POST" style="display:inline-block;">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Fila oculta con detalles del producto -->
                                            <tr id="detalles-{{ $producto->codigo_pro }}" style="display:none;">
                                                <td colspan="6">
                                                    <strong>Detalles del Producto:</strong>
                                                    @if ($producto->detalles->count())
                                                        <ul>
                                                            @foreach ($producto->detalles as $detalle)
                                                                <li><strong>ID Detalle:</strong> {{ $detalle->id_detpro }}</li>
                                                                <li><strong>Tipo de Animal:</strong>
                                                                    {{ $detalle->tipo_animal_detpro }}</li>
                                                                <li><strong>Tamaño/Raza:</strong>
                                                                    {{ $detalle->tamano_raza_detpro }}</li>
                                                                <li><strong>Peso (Libras):</strong>
                                                                    {{ $detalle->peso_libras_detpro }} lbs</li>
                                                                <li><strong>Precio por Libra:</strong>
                                                                    ${{ number_format($detalle->precio_libras_detpro, 2) }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p>No hay detalles disponibles para este producto.</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        {{ $productos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Función para mostrar/ocultar los detalles del producto
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.toggle-detalles');
            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetId = button.getAttribute('data-target');
                    const targetRow = document.getElementById(targetId);
                    if (targetRow.style.display === 'none' || targetRow.style.display === '') {
                        targetRow.style.display = 'table-row';
                    } else {
                        targetRow.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection


