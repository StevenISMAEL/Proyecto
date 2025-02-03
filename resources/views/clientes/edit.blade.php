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
                    <h3 class="panel-title">Editar Cliente</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('clientes.update', $cliente->cedula_cli) }}" role="form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" name="cedula_cli" class="form-control input-sm" value="{{ $cliente->cedula_cli }}" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" name="nombre_cli" class="form-control input-sm" value="{{ $cliente->nombre_cli }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="telefono_cli" class="form-control input-sm" value="{{ $cliente->telefono_cli }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="direccion_cli" class="form-control input-sm" value="{{ $cliente->direccion_cli }}">
                        </div>
                        <div class="form-group">
                            <input type="email" name="correo_cli" class="form-control input-sm" value="{{ $cliente->correo_cli }}" required>
                        </div>
                        <div class="form-group">
                            <input type="date" name="fecha_registro_cli" class="form-control input-sm" value="{{ $cliente->fecha_registro_cli }}" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-info btn-block">Atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
