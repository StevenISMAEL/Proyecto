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
                        <h3 class="panel-title">Nuevo Kardex</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('kardex.store') }}" role="form">
                            {{ csrf_field() }}

                            <!-- Datos del Kardex -->
                            <h4>Datos del Kardex</h4>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="id_kar" id="id_kar" class="form-control input-sm"
                                            placeholder="ID Kardex" required>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <select name="codigo_pro" id="codigo_pro" class="form-control input-sm"
                                            required onchange="mostrarDetalles()">
                                            <option value="" disabled selected>Seleccione un producto</option>
                                            @foreach ($productos as $producto)
                                                <option value="{{ $producto->codigo_pro }}"
                                                    data-detalles="{{ json_encode($producto->detalles) }}"
                                                    data-descripcion="{{ $producto->descripcion_pro }}">
                                                    {{ $producto->nombre_pro }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="stock_kar" id="stock_kar" class="form-control input-sm"
                                            placeholder="Stock" required>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="minimo_kar" id="minimo_kar" class="form-control input-sm"
                                            placeholder="Stock Mínimo" required>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="maximo_kar" id="maximo_kar" class="form-control input-sm"
                                            placeholder="Stock Máximo" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles del Producto Seleccionado -->
                            <div id="detalles-producto" style="display: none; margin-top: 20px;">
                                <h4>Detalles del Producto Seleccionado</h4>
                                <div id="detalles-container">
                                    <!-- Los detalles se rellenarán dinámicamente -->
                                    <ul>
                                        <li><strong>ID Detalle:</strong> <span id="id-detalle"></span></li>
                                        <li><strong>Tipo de Animal:</strong> <span id="tipo-animal"></span></li>
                                        <li><strong>Tamaño/Raza:</strong> <span id="tamano-raza"></span></li>
                                        <li><strong>Peso (Libras):</strong> <span id="peso-libras"></span></li>
                                        <li><strong>Precio por Libra:</strong> <span id="precio-libras"></span></li>
                                        <li><strong>ID Producto:</strong> <span id="id-producto"></span></li>
                                        <li><strong>Descripción Producto:</strong> <span id="descripcion-producto"></span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="submit" value="Guardar" class="btn btn-success btn-block">
                                    <a href="{{ route('kardex.index') }}" class="btn btn-info btn-block">Atrás</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        function mostrarDetalles() {
            const selectProducto = document.getElementById('codigo_pro');
            const idDetalle = document.getElementById('id-detalle');
            const tipoAnimal = document.getElementById('tipo-animal');
            const tamanoRaza = document.getElementById('tamano-raza');
            const pesoLibras = document.getElementById('peso-libras');
            const precioLibras = document.getElementById('precio-libras');
            const idProducto = document.getElementById('id-producto');
            const descripcionProducto = document.getElementById('descripcion-producto');
            const detallesProducto = document.getElementById('detalles-producto');

            const opcionSeleccionada = selectProducto.options[selectProducto.selectedIndex];
            const detalles = JSON.parse(opcionSeleccionada.getAttribute('data-detalles') || '[]');
            const descripcion = opcionSeleccionada.getAttribute('data-descripcion');

            // Mostrar los detalles específicos
            if (detalles.length > 0) {
                const detalle = detalles[0]; // Suponiendo que solo se muestra el primer detalle

                // Llenar los campos de detalles
                idDetalle.textContent = detalle.id_detpro || 'N/A';
                tipoAnimal.textContent = detalle.tipo_animal_detpro || 'N/A';
                tamanoRaza.textContent = detalle.tamano_raza_detpro || 'N/A';
                pesoLibras.textContent = detalle.peso_libras_detpro ? `${detalle.peso_libras_detpro} lbs` : 'N/A';
                precioLibras.textContent = detalle.precio_libras_detpro ? `$${detalle.precio_libras_detpro}` : 'N/A';
            } else {
                // Si no hay detalles, poner N/A
                idDetalle.textContent = 'N/A';
                tipoAnimal.textContent = 'N/A';
                tamanoRaza.textContent = 'N/A';
                pesoLibras.textContent = 'N/A';
                precioLibras.textContent = 'N/A';
            }

            // Mostrar el ID Producto y la Descripción
            idProducto.textContent = opcionSeleccionada.value;
            descripcionProducto.textContent = descripcion || 'No disponible';

            // Mostrar la sección de detalles
            detallesProducto.style.display = 'block';
        }
    </script>
@endsection
@endsection
