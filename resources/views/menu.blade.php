@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <!-- Barra superior de usuario -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <span class="navbar-text">
                    <strong>Usuario actual:</strong> {{ Auth::user()->name }}
                </span>
                <form class="d-flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </nav>

        <!-- Menú principal -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Reporte de Compras & Ventas 2025</h3>
                    </div>
                    <div class="panel-body">
                        <canvas id="ventasComprasChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de bienvenida -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h4 class="text-primary">¡Bienvenido al Panel de Control!</h4>
                        <p class="text-muted">
                            Aquí puedes consultar métricas generales, gráficas y detalles recientes de tus ventas y compras.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de métricas -->
        <div class="row">
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #f0ad4e;">
                    <h3><i class="glyphicon glyphicon-list-alt"></i> Total Productos</h3>
                    <p style="font-size: 24px;">{{ $productos->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5bc0de;">
                    <h3><i class="glyphicon glyphicon-apple"></i> Productos Alimenticios</h3>
                    <p style="font-size: 24px;">{{ $productos->where('alimenticio_pro', 1)->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5cb85c;">
                    <h3><i class="glyphicon glyphicon-usd"></i> Precio Promedio</h3>
                    <p style="font-size: 24px;">${{ number_format($productos->avg('precio_unitario_pro'), 2) }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #d9534f;">
                    <h3><i class="glyphicon glyphicon-tag"></i> Último Producto</h3>
                    <p style="font-size: 24px;">{{ $productos->last()->nombre_pro ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Sección de ventas y compras recientes -->
        <div class="row">
            <div class="col-md-6">
                <!-- Últimas ventas -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Últimas Ventas</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Factura Nº</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id_ven }}</td>
                                        <td>{{ $venta->nombre_cli_ven }}</td>
                                        <td>{{ \Carbon\Carbon::parse($venta->fecha_emision_ven)->format('d-m-Y') }}</td>
                                        <td>${{ number_format($venta->total_ven, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('ventas.index') }}" class="btn btn-primary">Ver todas las facturas</a>
                    </div>
                </div>

                <!-- Últimas Compras -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Últimas Compras</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Compra</th>
                                    <th>Proveedor</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $compra)
                                    <tr>
                                        <td>{{ $compra->id_com }}</td>
                                        <td>{{ $compra->nombre_proveedor_com }}</td>
                                        <td>{{ \Carbon\Carbon::parse($compra->fecha_emision_com)->format('d-m-Y') }}</td>
                                        <td>${{ number_format($compra->detalles->sum('precio_unitario_detcom'), 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('compras.index') }}" class="btn btn-primary">Ver todas las compras</a>
                    </div>
                </div>
            </div>

            <!-- Sección de productos recientes -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4>Productos Recientes</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach ($productos as $producto)
                                <li class="list-group-item">
                                    <span>{{ $producto->nombre_pro }}</span>
                                    <span class="badge">${{ number_format($producto->precio_unitario_pro, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('productos.index') }}" class="btn btn-primary">Ver todos los productos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para la gráfica -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('ventasComprasChart').getContext('2d');
        var ventasComprasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Ventas',
                    data: @json($ventasPorMes),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Compras',
                    data: @json($comprasPorMes),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
