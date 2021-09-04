@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Datos del usuario</strong>
            </div>
            <div class="card-body">
                <div id="pay-invoice">
                    <div class="card-body">
                        {{ Form::open(array('method' => 'post')) }}
                            <div class="card-title">
                                <h3 class="text-center">@if($usuario->id_usuario == null) Crear usuario @else Modificar usuario @endif</h3>
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger">
                                        @foreach($errors as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                            </div><hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1"><b>*Tercero</b></label>
                                        <input name="id_ter" type="text" class="form-control" aria-required="true" required aria-invalid="false" value="{{ $usuario->nombre }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                     <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1"><b>Descripción</b></label>
                                        <input name="descripcion" class="form-control" aria-required="true"  aria-invalid="false" value="{{ $usuario->descripcion }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                     <div class="form-group">
                                        <label class="control-label mb-1"><b>*Estado</b></label>
                                        <select name="estado" class="form-control" required>
                                            <option @if($usuario->estado == 0) selected @endif value="0">Inactiva</option>
                                            <option @if($usuario->estado == 1 || $usuario->id_usuario == null) selected @endif value="1">Activa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                    </center>
                                </div>
                            </div>
                            {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection