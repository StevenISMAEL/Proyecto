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
                        <h3 class="panel-title">Editar Venta</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('ventas.update', $venta->id_ven) }}" method="POST" role="form">
                            @csrf
                            @method('PUT')

                            <!-- Información de la venta -->
                            <h4>Información de la Venta</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cedula_cli">Cliente</label>
                                        <select name="venta[cedula_cli]" id="cedula_cli" class="form-control" required>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->cedula_cli }}"
                                                    {{ $venta->cedula_cli == $cliente->cedula_cli ? 'selected' : '' }}>
                                                    {{ $cliente->nombre_cli }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_emision_ven">Fecha de Emisión</label>
                                        <input type="date" name="venta[fecha_emision_ven]" id="fecha_emision_ven"
                                            class="form-control" value="{{ $venta->fecha_emision_ven }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles de la venta -->
                            <h4>Detalles de la Venta</h4>
                            <div id="detalles-container">
                                @foreach ($venta->detalles as $index => $detalle)
                                    <div class="detalle-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="codigo_pro_{{ $index }}">Producto</label>
                                                    <select name="detalles[{{ $index }}][codigo_pro]"
                                                        id="codigo_pro_{{ $index }}" class="form-control" required>
                                                        @foreach ($productos as $producto)
                                                            <option value="{{ $producto->codigo_pro }}"
                                                                {{ $detalle->codigo_pro == $producto->codigo_pro ? 'selected' : '' }}>
                                                                {{ $producto->nombre_pro }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cantidad_{{ $index }}">Cantidad</label>
                                                    <input type="number" name="detalles[{{ $index }}][cantidad_pro_detven]"
                                                        id="cantidad_{{ $index }}" class="form-control"
                                                        value="{{ $detalle->cantidad_pro_detven }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="precio_unitario_{{ $index }}">Precio</label>
                                                    <input type="number" name="detalles[{{ $index }}][precio_unitario_detven]"
                                                        id="precio_unitario_{{ $index }}" class="form-control"
                                                        value="{{ $detalle->precio_unitario_detven }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="iva_{{ $index }}">IVA (%)</label>
                                                    <input type="number" name="detalles[{{ $index }}][iva_detven]"
                                                        id="iva_{{ $index }}" class="form-control"
                                                        value="{{ $detalle->iva_detven }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Botones -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-block">Actualizar Venta</button>
                                    <a href="{{ route('ventas.index') }}" class="btn btn-info btn-block">Atrás</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
