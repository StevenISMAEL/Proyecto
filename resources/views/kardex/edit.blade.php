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
                        <h3 class="panel-title">Editar Kardex</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('kardex.update', $kardex->id_kar) }}" role="form">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <!-- Datos del Kardex -->
                                <h4>Datos del Kardex</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="id_kar" id="id_kar"
                                                class="form-control input-sm" placeholder="ID Kardex"
                                                value="{{ $kardex->id_kar }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <select name="codigo_pro" id="codigo_pro" class="form-control input-sm" required onchange="mostrarDetalles()">
                                                <option value="" disabled>Seleccione un producto</option>
                                                @foreach ($productos as $producto)
                                                    <option value="{{ $producto->codigo_pro }}"
                                                        data-detalles="{{ json_encode($producto->detalles) }}"
                                                        {{ $kardex->codigo_pro == $producto->codigo_pro ? 'selected' : '' }}>
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
                                            <input type="number" name="stock_kar" id="stock_kar"
                                                class="form-control input-sm" placeholder="Stock"
                                                value="{{ $kardex->stock_kar }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="minimo_kar" id="minimo_kar"
                                                class="form-control input-sm" placeholder="Stock Mínimo"
                                                value="{{ $kardex->minimo_kar }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="maximo_kar" id="maximo_kar"
                                                class="form-control input-sm" placeholder="Stock Máximo"
                                                value="{{ $kardex->maximo_kar }}" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles del Producto Seleccionado -->
                                <div id="detalles-producto" style="display: none; margin-top: 20px;">
                                    <h4>Detalles del Producto Seleccionado</h4>
                                    <div id="detalles-container">
                                        <!-- Los detalles se rellenarán dinámicamente -->
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('kardex.index') }}" class="btn btn-info btn-block">Atrás</a>
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
        function mostrarDetalles() {
            const selectProducto = document.getElementById('codigo_pro');
            const detallesContainer = document.getElementById('detalles-container');
            const detallesProducto = document.getElementById('detalles-producto');
            
            const opcionSeleccionada = selectProducto.options[selectProducto.selectedIndex];
            const detalles = JSON.parse(opcionSeleccionada.getAttribute('data-detalles') || '[]');
            
            detallesContainer.innerHTML = ''; // Limpia los detalles previos

            if (detalles.length > 0) {
                detallesProducto.style.display = 'block';

                detalles.forEach(detalle => {
                    const detalleHTML = `
                        <ul>
                            <li><strong>ID Detalle:</strong> ${detalle.id_detpro}</li>
                            <li><strong>Tipo de Animal:</strong> ${detalle.tipo_animal_detpro}</li>
                            <li><strong>Tamaño/Raza:</strong> ${detalle.tamano_raza_detpro}</li>
                            <li><strong>Peso (Libras):</strong> ${detalle.peso_libras_detpro || 'N/A'}</li>
                            <li><strong>Precio por Libra:</strong> ${detalle.precio_libras_detpro ? '$' + detalle.precio_libras_detpro : 'N/A'}</li>
                        </ul>
                        <hr>`;
                    detallesContainer.innerHTML += detalleHTML;
                });
            } else {
                detallesProducto.style.display = 'none';
            }
        }

        // Llamar a la función al cargar la página para mostrar los detalles del producto seleccionado
        document.addEventListener('DOMContentLoaded', function () {
            mostrarDetalles();
        });
    </script>
@endsection

@endsection
