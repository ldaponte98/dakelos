@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <center>
                    <strong>Detalle caja #{{ $caja->id_caja }}</strong><br>
                    <label>{{ $caja->usuario->tercero->nombre_completo() }} - {{ $caja->fecha_apertura }}</label>
                </center>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection