@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <!-- Barra superior de usuario -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container-fluid d-flex justify-content-between">
                <span class="navbar-text text-white">
                    <strong>Usuario actual:</strong> {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </nav>

        <!-- Menú principal -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="panel panel-default shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="panel-heading">
                        <h3 class="text-center">Reporte de Compras & Ventas 2025</h3>
                    </div>
                    <div class="panel-body">
                        <canvas id="ventasComprasChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de métricas -->
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Productos</div>
                    <div class="card-body">
                        <p class="card-text" style="font-size: 24px;">{{ $productos->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Productos Alimenticios</div>
                    <div class="card-body">
                        <p class="card-text" style="font-size: 24px;">{{ $productos->where('alimenticio_pro', 1)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Precio Promedio</div>
                    <div class="card-body">
                        <p class="card-text" style="font-size: 24px;">${{ number_format($productos->avg('precio_unitario_pro'), 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Último Producto</div>
                    <div class="card-body">
                        <p class="card-text" style="font-size: 24px;">{{ $productos->last()->nombre_pro ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de ventas y compras recientes -->
        <div class="row">
            <div class="col-md-6">
                <!-- Últimas ventas -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Últimas Ventas</div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
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
                        <a href="{{ route('ventas.index') }}" class="btn btn-primary btn-sm">Ver todas las facturas</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Últimas Compras -->
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">Últimas Compras</div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
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
                        <a href="{{ route('compras.index') }}" class="btn btn-secondary btn-sm">Ver todas las compras</a>
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
