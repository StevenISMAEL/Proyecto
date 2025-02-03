@extends('plantilla.plantilla')

@section('content')
<div class="container-fluid">
    <!-- Sección de métricas -->
    <div class="row">
        <div class="col-md-3">
            <div class="panel-card" style="background-color: #f0ad4e;">
                <h3><i class="glyphicon glyphicon-user"></i> Total Clientes</h3>
                <p style="font-size: 24px;">{{ $clientes->count() }}</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-card" style="background-color: #5bc0de;">
                <h3><i class="glyphicon glyphicon-check"></i> Activos</h3>
                <p style="font-size: 24px;">{{ $clientes->where('activo', 1)->count() }}</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-card" style="background-color: #5cb85c;">
                <h3><i class="glyphicon glyphicon-remove"></i> Inactivos</h3>
                <p style="font-size: 24px;">{{ $clientes->where('activo', 0)->count() }}</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-card" style="background-color: #d9534f;">
                <h3><i class="glyphicon glyphicon-time"></i> Última Edición</h3>
                <p style="font-size: 24px;">
                    {{ $clientes->max('updated_at') ? $clientes->max('updated_at')->format('d-m-Y') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Sección de clientes -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-left">
                        <h3>Lista de Clientes</h3>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('clientes.create') }}" class="btn btn-info">Añadir Cliente</a>
                    </div>
                    <div class="table-container">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->cedula_cli }}</td>
                                    <td>{{ $cliente->nombre_cli }}</td>
                                    <td>{{ $cliente->correo_cli }}</td>
                                    <td>{{ $cliente->telefono_cli }}</td>
                                    <td>{{ $cliente->direccion_cli }}</td>
                                    <td>{{ $cliente->fecha_registro_cli }}</td>
                                    <td>
                                        <!-- Botón de Editar -->
                                        <a href="{{ route('clientes.edit', $cliente->cedula_cli) }}" class="btn btn-warning btn-sm" style="border-radius: 5px; padding: 5px 10px;">
                                            <i class="glyphicon glyphicon-pencil"></i> Editar
                                        </a>
                                    
                                        <!-- Formulario de eliminación con el botón de Eliminar -->
                                        <form action="{{ route('clientes.destroy', $cliente->cedula_cli) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 5px; padding: 5px 10px;">
                                                <i class="glyphicon glyphicon-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $clientes->links() }} <!-- Paginación -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
