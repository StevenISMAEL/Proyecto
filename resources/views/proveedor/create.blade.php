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
            @if(Session::has('success'))
            <div class="alert alert-info">
                {{Session::get('success')}}
            </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nuevo Proveedor </h3>
                </div>
                <div class="panel-body">                    
                    <div class="table-container">
                        <form method="POST" action="{{ route('proveedor.store') }}" role="form">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="ruc" id="ruc" class="form-control input-sm" placeholder="RUC" required>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="nombre" id="nombre" class="form-control input-sm" placeholder="Nombre del proveedor" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="email" name="correo" id="correo" class="form-control input-sm" placeholder="Correo electrónico">
                            </div>
                            <div class="form-group">
                                <input type="text" name="telefono" id="telefono" class="form-control input-sm" placeholder="Teléfono">
                            </div>
                            <div class="form-group">
                                <input type="text" name="direccion" id="direccion" class="form-control input-sm" placeholder="Dirección">
                            </div>
                            <div class="form-group">
                                <label for="activo">Activo</label>
                                <select name="activo" id="activo" class="form-control">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="notas_proveedor" id="notas_proveedor" class="form-control input-sm" placeholder="Apuntes del proveedor" required>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="submit" value="Guardar" class="btn btn-success btn-block">
                                    <a href="{{ route('proveedor.index') }}" class="btn btn-info btn-block">Atrás</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
