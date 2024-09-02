@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Datos del recordatorio de cita</strong>
            </div>
            <div class="card-body">
                <div id="pay-invoice">
                    <div class="card-body">
                        {{ Form::open(array('method' => 'post')) }}
                            <div class="card-title">
                                <h3 class="text-center">@if($recordatorio->id == null) Crear recordatorio @else Modificar recordatorio @endif</h3>
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
                                        <label for="cc-payment" class="control-label mb-1"><b>*Unidad de tiempo</b></label>
                                        <select name="unidad_tiempo" data-placeholder="Seleccione..." class="form-control select2" required>
                                            <option value="" label="default"></option>
                                            @foreach($unidades_tiempo as $item)
                                                <option @if ($recordatorio->unidad_tiempo == $item->id) selected @endif value="{{ $item->id }}">{{ $item->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                     <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1"><b>*Tiempo</b></label>
                                        <input type="number" autocomplete="off" name="tiempo" class="form-control" aria-required="true"  aria-invalid="false" value="{{ $recordatorio->tiempo }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                     <div class="form-group">
                                        <label class="control-label mb-1"><b>*Estado</b></label>
                                        <select name="estado" class="form-control" required>
                                            <option @if($recordatorio->estado == 0) selected @endif value="0">Inactivo</option>
                                            <option @if($recordatorio->estado == 1 || $recordatorio->id == null) selected @endif value="1">Activo</option>
                                        </select>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                    </center>
                                    <br>
                                    <div class="alert alert-warning">
                                        <strong>El servidor ejecuta el proceso de notificación de estos recordatorios todos los dias en todas las horas del dia exactamente.</strong>
                                    </div>
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