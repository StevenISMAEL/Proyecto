@extends('plantilla.plantilla')

@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nuevo Cliente</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('clientes.store') }}" role="form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="cedula_cli" class="form-control input-sm" placeholder="Cédula" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="nombre_cli" class="form-control input-sm" placeholder="Nombre del cliente" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="telefono_cli" class="form-control input-sm" placeholder="Teléfono" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="direccion_cli" class="form-control input-sm" placeholder="Dirección">
                        </div>
                        <div class="form-group">
                            <input type="email" name="correo_cli" class="form-control input-sm" placeholder="Correo electrónico" required>
                        </div>
                        <div class="form-group">
                            <input type="date" name="fecha_registro_cli" class="form-control input-sm" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-info btn-block">Atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
