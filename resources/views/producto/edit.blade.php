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
                        <h3 class="panel-title">Editar Producto</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('productos.update', $producto->codigo_pro) }}"
                                role="form">
                                @csrf
                                @method('PUT')

                                <!-- Datos del Producto -->
                                <h4>Datos del Producto</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="producto[codigo_pro]" id="codigo"
                                                class="form-control input-sm"
                                                value="{{ old('producto.codigo_pro', $producto->codigo_pro) }}"
                                                placeholder="Código del producto" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="producto[nombre_pro]" id="nombre"
                                                class="form-control input-sm"
                                                value="{{ old('producto.nombre_pro', $producto->nombre_pro) }}"
                                                placeholder="Nombre del producto" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea name="producto[descripcion_pro]" class="form-control input-sm" placeholder="Descripción del producto">{{ old('producto.descripcion_pro', $producto->descripcion_pro) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="producto[precio_unitario_pro]" id="precio_unitario"
                                                class="form-control input-sm"
                                                value="{{ old('producto.precio_unitario_pro', $producto->precio_unitario_pro) }}"
                                                placeholder="Precio unitario" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="alimenticio">¿Producto Alimenticio?</label>
                                            <select name="producto[alimenticio_pro]" id="alimenticio"
                                                class="form-control input-sm" required onchange="togglePesoPrecio()">
                                                <option value="1"
                                                    {{ $producto->alimenticio_pro == 1 ? 'selected' : '' }}>Sí</option>
                                                <option value="0"
                                                    {{ $producto->alimenticio_pro == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles del Producto -->
                                <h4>Detalles del Producto</h4>
                                <div id="detalles-container">
                                    @foreach ($producto->detalles as $index => $detalle)
                                        <div class="detalle-item">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="detalles[{{ $index }}][id_detpro]" value="{{ old('detalles.' . $index . '.id_detpro', $detalle->id_detpro) }}" class="form-control input-sm" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="detalles[{{ $index }}][tipo_animal_detpro]"
                                                            class="form-control input-sm"
                                                            value="{{ old('detalles.' . $index . '.tipo_animal_detpro', $detalle->tipo_animal_detpro) }}"
                                                            placeholder="Tipo de animal" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="detalles[{{ $index }}][tamano_raza_detpro]"
                                                            class="form-control input-sm"
                                                            value="{{ old('detalles.' . $index . '.tamano_raza_detpro', $detalle->tamano_raza_detpro) }}"
                                                            placeholder="Tamaño/Raza" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- Campos de Peso y Precio, visibles si es producto alimenticio -->
                                                <div id="peso-libras-container" class="col-xs-6 col-sm-6 col-md-6"
                                                    style="{{ $producto->alimenticio_pro == 1 ? 'display: block;' : 'display: none;' }}">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][peso_libras_detpro]"
                                                            class="form-control input-sm"
                                                            value="{{ old('detalles.' . $index . '.peso_libras_detpro', $detalle->peso_libras_detpro) }}"
                                                            placeholder="Peso en libras" step="0.01">
                                                    </div>
                                                </div>
                                                <div id="precio-libras-container" class="col-xs-6 col-sm-6 col-md-6"
                                                    style="{{ $producto->alimenticio_pro == 1 ? 'display: block;' : 'display: none;' }}">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][precio_libras_detpro]"
                                                            class="form-control input-sm"
                                                            value="{{ old('detalles.' . $index . '.precio_libras_detpro', $detalle->precio_libras_detpro) }}"
                                                            placeholder="Precio por libras" step="0.01">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                                        
                                <div class="row mt-4">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('productos.index') }}" class="btn btn-info btn-block">Atrás</a>
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
        // Función para mostrar u ocultar los campos de peso y precio
        function togglePesoPrecio() {
            var alimenticio = document.getElementById('alimenticio').value;
            var pesoContainer = document.getElementById('peso-libras-container');
            var precioContainer = document.getElementById('precio-libras-container');

            if (alimenticio == '1') {
                pesoContainer.style.display = 'block';
                precioContainer.style.display = 'block';
            } else {
                pesoContainer.style.display = 'none';
                precioContainer.style.display = 'none';
            }
        }

        // Llamar a la función para inicializar el estado correcto al cargar la página
        togglePesoPrecio();
    </script>
@endsection
@endsection
