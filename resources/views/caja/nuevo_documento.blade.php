@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Datos del documento</strong>
            </div>
            <div class="card-body">
                <div id="pay-invoice">
                    <div class="card-body">
                        {{ Form::open(array('method' => 'post', 'id' => 'form-documento')) }}
                            <div class="card-title">
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger">
                                        @foreach($errors as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        @php
                                            $tipos = \App\Dominio::where('id_padre', 15)
                                                                 ->where('id_dominio' ,'<>', 16)
                                                                 ->where('id_dominio' ,'<>', 17)
                                                                 ->get();
                                        @endphp
                                        <label for="cc-payment" class="control-label mb-1"><b>*Tipo</b></label>
                                        <select onchange="validarTipo(this.value)" id="id_dominio_tipo_factura" name="id_dominio_tipo_factura" class="form-control" required>
                                            @foreach ($tipos as $item)
                                                <option @if ($item->id_dominio == $factura->id_dominio_tipo_factura)
                                                    selected 
                                                @endif value="{{ $item->id_dominio }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                     <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1"><b>*Valor</b></label>
                                        <input id="valor" name="valor" type="number" class="form-control" aria-required="true"  aria-invalid="false" value="{{ $factura->valor }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 hide" id="div-acciones-caja">
                                    <div class="form-group">
                                        <label for="acciones_caja" class="control-label mb-1"><b>*Acciones de caja</b></label>
                                        <select onchange="validarAcciones(this.value)" id="acciones_caja" name="acciones_caja" class="form-control" required>
                                            <option value="no-descontar">No descontar de caja actual</option>
                                            <option value="descontar">Descontar de caja actual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="div-forma-pago">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1"><b>Forma de pago</b></label>
                                        <select id="forma_pago" name="forma_pago"
                                            data-placeholder="Escoje una" class="standardSelect form-control">
                                            <option value="" label="default"></option>
                                            @foreach ($formas_pago as $item)
                                                <option value="{{ $item->id_dominio }}">
                                                    {{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                   </div>
                               </div>
                                <div class="col-sm-12">
                                     <div class="form-group">
                                        @php
                                        $items = \App\Tercero::all()->where('id_licencia', session('id_licencia'));
                                        @endphp
                                        <label for="cc-payment" class="control-label mb-1"><b>Titular</b></label>
                                        <select name="id_tercero" id="id_tercero" data-placeholder="Consulta aqui por nombre o identificacion..." class="form-control select2" required>
                                            <option value="" label="default"></option>
                                            @foreach($items as $item)
                                            <option @if ($item->id_tercero == $factura->id_tercero)
                                                selected 
                                            @endif value="{{ $item->id_tercero }}">{{ $item->nombre_completo() }} ({{ $item->identificacion }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cc-payment" class="control-label mb-1"><b>Descripción para titular</b></label>
                                    <textarea rows="2" name="descripciones" class="form-control" rows="1"></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label for="cc-payment" class="control-label mb-1"><b>Observaciones internas</b></label>
                                    <textarea rows="2" name="observaciones" class="form-control" aria-required="true"  aria-invalid="false">{{ $factura->observaciones }}</textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <button type="button" onclick="crear()" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                    </center>
                                </div>
                            </div>
                            <script>
                                function validarTipo(id) {
                                    if(id == {{ \App\Dominio::get("Factura a credito (Saldo pendiente)") }}){
                                        $("#div-forma-pago").fadeOut()
                                        $("#div-acciones-caja").fadeIn()
                                    }else{
                                        $("#div-forma-pago").fadeIn()
                                        $("#div-acciones-caja").fadeOut()
                                    }
                                }

                                function validarAcciones(accion) {
                                    if(accion == "descontar"){
                                        $("#div-forma-pago").fadeIn()
                                    }else{
                                        $("#div-forma-pago").fadeOut()
                                    }
                                }

                                function crear() {
                                    if(validarCampos()){
                                        $("#form-documento").submit()
                                    }
                                }

                                function validarCampos() {
                                    if($("#valor").val() == 0 || $("#valor").val() == "" || $("#valor").val() == null){
                                        toastr.error("El valor del documento es obligatorio", "Error");
                                        return false;
                                    }
                                    if($("#id_tercero").val() == 0 || $("#id_tercero").val() == "" || $("#id_tercero").val() == null){
                                        toastr.error("El titular del documento es obligatorio", "Error");
                                        return false;
                                    }
                                    if($("#id_dominio_tipo_factura").val() == {{ \App\Dominio::get("Factura a credito (Saldo pendiente)") }}){
                                        if($("#acciones_caja").val() == "descontar"){
                                            if($("#forma_pago").val() == null || $("#forma_pago").val() == ""){
                                                toastr.error("Debe escoger una forma de pago", "Error");
                                                return false;
                                            }
                                        }
                                    }else{
                                        if($("#forma_pago").val() == null || $("#forma_pago").val() == ""){
                                            toastr.error("Debe escoger una forma de pago", "Error");
                                            return false;
                                        }
                                    }
                                    return true
                                }
                            </script>
                            {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection