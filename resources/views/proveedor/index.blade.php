@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <!-- Sección de métricas -->
        <div class="row">
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #f0ad4e;">
                    <h3><i class="glyphicon glyphicon-briefcase"></i> Total Proveedores</h3>
                    <p style="font-size: 24px;">{{ $proveedores->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5bc0de;">
                    <h3><i class="glyphicon glyphicon-check"></i> Activos</h3>
                    <p style="font-size: 24px;">{{ $proveedores->where('activo', 1)->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5cb85c;">
                    <h3><i class="glyphicon glyphicon-pushpin"></i> Inactivos</h3>
                    <p style="font-size: 24px;">{{ $proveedores->where('activo', 0)->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #d9534f;">
                    <h3><i class="glyphicon glyphicon-time"></i> Última Edición</h3>
                    <p style="font-size: 24px;">
                        {{ $proveedores->max('updated_at') ? $proveedores->max('updated_at')->format('d-m-Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sección de proveedores -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista de Proveedores</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('proveedor.create') }}" class="btn btn-info">Añadir Proveedor</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>RUC</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Activo</th>
                                    <th>Anotaciones del Proveedor</th>
                                    <th>Fecha de Registro</th>
                                    <th>Última Edición</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @if ($proveedores->count())
                                        @foreach ($proveedores as $proveedor)
                                            <tr>
                                                <td>{{ $proveedor->ruc }}</td>
                                                <td>{{ $proveedor->nombre }}</td>
                                                <td>{{ $proveedor->correo }}</td>
                                                <td>{{ $proveedor->telefono }}</td>
                                                <td>{{ $proveedor->direccion }}</td>
                                                <td>{{ $proveedor->activo ? 'Sí' : 'No' }}</td>
                                                <td>{{ $proveedor->notas_proveedor }}</td>
                                                <td>{{ $proveedor->created_at->format('d-m-Y') }}</td>
                                                <td>{{ $proveedor->updated_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ route('proveedor.edit', $proveedor->ruc) }}"
                                                        class="btn btn-warning btn-sm"
                                                        style="border-radius: 5px; padding: 5px 10px;">
                                                        <i class="glyphicon glyphicon-pencil"></i> Editar
                                                    </a>
                                                    <form action="{{ route('proveedor.destroy', $proveedor->ruc) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            style="border-radius: 5px; padding: 5px 10px;">
                                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $proveedores->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
