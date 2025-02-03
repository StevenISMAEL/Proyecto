@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-info">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Editar Compra</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('compras.update', $compra->id_com) }}" role="form">
                                @csrf
                                @method('PUT')

                                <!-- Datos de la Compra -->
                                <h4>Datos de la Compra</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="compra[id_com]" id="id_com"
                                                class="form-control input-sm" value="{{ $compra->id_com }}" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <select name="compra[nombre_proveedor_com]" id="nombre_proveedor_com"
                                                class="form-control input-sm" required onchange="updateRuc()">
                                                <option value="" disabled selected>Seleccione un Proveedor</option>
                                                @foreach ($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->nombre }}"
                                                        data-ruc="{{ $proveedor->ruc }}"
                                                        @if ($compra->proveedor->nombre == $proveedor->nombre) selected @endif>
                                                        {{ $proveedor->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="compra[ruc_pro]" id="ruc_pro"
                                                class="form-control input-sm" value="{{ $compra->proveedor->ruc }}" readonly
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="date" name="compra[fecha_emision_com]" id="fecha_emision_com"
                                                class="form-control input-sm" value="{{ $compra->fecha_emision_com }}"
                                                readonly required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles de la Compra -->
                                <h4>Detalles de la Compra</h4>
                                <div id="detalles-container">
                                    @foreach ($compra->detalles as $index => $detalle)
                                        <div class="detalle-item">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="detalles[{{ $index }}][id_detcom]"
                                                            class="form-control input-sm" value="{{ $detalle->id_detcom }}"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="detalles[{{ $index }}][codigo_pro]"
                                                            id="codigo_pro" class="form-control input-sm"
                                                            value="{{ $detalle->producto->codigo_pro }}" readonly required>
                                                    </div>
                                                </div>
                                                <!-- nombre del producto autocompletado y su ID -->
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <select
                                                            name="detalles[{{ $index }}][nombre_producto_detcom]"
                                                            id="nombre_producto_detcom" class="form-control input-sm"
                                                            required onchange="updateProductoDetails({{ $index }})">
                                                            <option value="" disabled selected>Seleccione un Producto
                                                            </option>
                                                            @foreach ($productos as $producto)
                                                                <option value="{{ $producto->nombre_pro }}"
                                                                    data-codigo="{{ $producto->codigo_pro }}"
                                                                    data-precio="{{ $producto->precio_unitario_pro }}"
                                                                    data-descripcion="{{ $producto->descripcion_pro }}"
                                                                    @if ($producto->nombre_pro == $detalle->producto->nombre_pro) selected @endif>
                                                                    {{ $producto->nombre_pro }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <!-- Descripción del Producto -->
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="form-group">
                                                                    <textarea name="detalles[{{ $index }}][descripcion_producto]" id="descripcion_producto"
                                                                        class="form-control input-sm" placeholder="Descripción del Producto" readonly>{{ $detalle->producto->descripcion_pro }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][cantidad_pro_detcom]"
                                                            class="form-control input-sm"
                                                            value="{{ $detalle->cantidad_pro_detcom }}"
                                                            placeholder="Cantidad" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][precio_unitario_detcom]"
                                                            id="precio_unitario_detcom" class="form-control input-sm"
                                                            value="{{ $detalle->precio_unitario_detcom }}" step="0.01"
                                                            readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][iva_detcom]"
                                                            class="form-control input-sm"
                                                            value="{{ $detalle->iva_detcom }}" placeholder="IVA (%)"
                                                            step="0.01" required>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    @endforeach
                                </div>

                                <!-- Botones -->
                                <div class="row mt-4">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('compras.index') }}" class="btn btn-info btn-block">Atrás</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Función para actualizar el campo RUC cuando se selecciona un proveedor
        function updateRuc() {
            var select = document.getElementById('nombre_proveedor_com');
            var rucField = document.getElementById('ruc_pro');
            var selectedOption = select.options[select.selectedIndex];
            var ruc = selectedOption.getAttribute('data-ruc');
            rucField.value = ruc;
        }

        // Función para autocompletar los detalles del producto (precio y descripción) cuando se selecciona un producto
        function updateProductoDetails(index) {
            var select = document.getElementById('nombre_producto_detcom');
            var codigoField = document.getElementById('codigo_pro');
            var precioField = document.getElementById('precio_unitario_detcom');
            var descripcionField = document.getElementById('descripcion_producto');
            var selectedOption = select.options[select.selectedIndex];

            // Obtener los atributos personalizados del producto seleccionado
            var codigo = selectedOption.getAttribute('data-codigo');
            var precio = selectedOption.getAttribute('data-precio');
            var descripcion = selectedOption.getAttribute('data-descripcion');

            // Asignar los valores a los campos correspondientes
            codigoField.value = codigo;
            precioField.value = precio;
            descripcionField.value = descripcion;
        }

        // Función para autocompletar la fecha actual en el campo de fecha de emisión
        document.getElementById('fecha_emision_com').value = new Date().toISOString().split('T')[0];
    </script>
@endsection

@endsection
