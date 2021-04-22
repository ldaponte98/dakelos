@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Datos del producto</strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        {{ Form::open(array('method' => 'post' ,'files' => true)) }}
                                        <div class="card-title">
                                            <h3 class="text-center">@if($producto->id_producto == null) Crear producto / servicio @else Modificar producto / servicio @endif</h3>
                                        </div><hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <img src="@if($producto->imagen == null or $producto->imagen == '') {{ asset('plantilla/images/app/sinimagen.jpg') }} @else {{ asset('imagenes/producto/'.$producto->imagen) }} @endif" id="img_imagen" alt="image" class="img-thumbnail" width="100%" height="200">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/*">
                                                            <label class="custom-file-label" for="imagen" id="nombre_archivo">Examinar</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                <label for="cc-payment" class="control-label mb-1"><b>*Nombre</b></label>
                                                                <input name="nombre" type="text" class="form-control" aria-required="true" required aria-invalid="false" value="{{ $producto->nombre }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                <label for="cc-payment" class="control-label mb-1"><b>*Tipo</b></label>
                                                                @php
                                                                    $categorias = \App\Categoria::all()->where('id_licencia', session('id_licencia'))->where('estado', 1);
                                                                @endphp
                                                                <select name="id_categoria" class="form-control" required>
                                                                    @foreach($categorias as $categoria)
                                                                        <option @if($producto->id_categoria == $categoria->id_categoria) selected @endif value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                     <div class="row">
                                                        <div class="col-sm-12">
                                                             <div class="form-group">
                                                                <label for="cc-payment" class="control-label mb-1"><b>Descripción</b></label>
                                                                <textarea rows="2" name="descripcion" class="form-control" aria-required="true"  aria-invalid="false" value="{{ $producto->descripcion }}">{{ $producto->descripcion }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                <label for="cc-payment" class="control-label mb-1"><b>*Precio venta (sin iva)</b></label>
                                                                <input name="precio_venta" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $producto->precio_venta }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                <label for="cc-payment" class="control-label mb-1"><b>*Precio de compra o utilidad</b></label>
                                                                <input name="precio_compra" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $producto->precio_compra }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                <label for="cc-payment" class="control-label mb-1"><b>Iva(%)</b></label>
                                                                <input name="iva" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $producto->iva }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                             <div class="form-group"><b>*Presentación</b></label>
                                                                @php
                                                                    $presentaciones = \App\Dominio::all()->where('id_padre', 24);
                                                                @endphp
                                                                <select name="id_dominio_presentacion" class="form-control" onchange="validar_presentacion()" required>
                                                                    @foreach($presentaciones as $tipo)
                                                                        <option @if($producto->id_dominio_presentacion == $tipo->id_dominio) selected @endif value="{{ $tipo->id_dominio }}">{{ $tipo->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                <label class="control-label mb-1"><b>*Estado</b></label>
                                                                <select name="estado" class="form-control" required>
                                                                    <option @if($producto->estado == 0) selected @endif value="0">Inactivo</option>
                                                                    <option @if($producto->estado == 1 || $producto->id_producto == null) selected @endif value="1">Activo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group" style="margin-left: 18px;">
                                                                <label for="descontado" class="form-check-label ">
                                                                    <input onclick="validar_inventario()" type="checkbox" id="descontado" name="descontado" @if($producto->descontado == 1) checked @endif class="form-check-input"><i>Deseo que este producto pueda descontarse del inventario al facturarlo.</i>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="div_inventario" @if($producto->descontado == 0) style="display: none;" @endif>
                                                        <div class="row">
                                                             <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="cc-payment" class="control-label mb-1"><b>*Contenido por producto</b></label> <i class="fa fa-info-circle" title="Este campo es el contenido total del producto, si es por unidad el valor por defecto es 1."></i>
                                                                    <div class="input-group mb-3">
                                                                        <input name="contenido" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $producto->contenido }}" >
                                                                        <div class="input-group-prepend">
                                                                            <label class="input-group-text" for="precio_compra" id="presentacion_contenido">Unidades</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                 <div class="form-group">
                                                                    <label for="cc-payment" class="control-label mb-1"><b>*Cantidad actual</b></label>
                                                                    <div class="input-group mb-3">
                                                                        <input name="cantidad_actual" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $producto->cantidad_actual }}" >
                                                                        <div class="input-group-prepend">
                                                                            <label class="input-group-text" for="cantidad_actual" id="presentacion_cantidad_actual">Unidades</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                             <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="cc-payment" class="control-label mb-1"><b>*Cantidad de alerta </b></label> <i class="fa fa-info-circle" title="Este campo indica la cantidad minima para que el sistema informe faltantes en el inventario de este producto."></i>
                                                                    <div class="input-group mb-3">
                                                                        <input name="cantidad_minimo_alerta" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $producto->cantidad_minimo_alerta }}">
                                                                        <div class="input-group-prepend">
                                                                            <label class="input-group-text" for="cantidad_minimo_alerta" id="presentacion_cantidad_alerta">Unidades</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div><center>
                                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                                    @if(count($errors) > 0)
                                                        <div class="alert alert-danger">
                                                            @foreach($errors as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </center>
                                                </div>
                                                </div>
                                            </div>
                                            
                                            {{ Form::close() }}
                                    </div>
                                </div>

                            </div>
                        </div> <!-- .card -->

                    </div>
</div>
 <script>
    function validar_inventario() {
        if($("#descontado").prop('checked') == true){
            $("#div_inventario").fadeIn()
            $("#contenido").prop('required', true);
            $("#cantidad_actual").prop('required', true);
            $("#cantidad_minimo_alerta").prop('required', true);
        }else{
            $("#div_inventario").fadeOut()
            $("#contenido").prop('required', false);
            $("#cantidad_actual").prop('required', false);
            $("#cantidad_minimo_alerta").prop('required', false);
        }
    }
    function validar_presentacion() {
        let presentacion = $('select[name="id_dominio_presentacion"] option:selected').text()
        $("#presentacion_contenido").html(presentacion)
        $("#presentacion_cantidad_actual").html(presentacion)
        $("#presentacion_cantidad_alerta").html(presentacion)
    }
    $(document).ready(function(){
         $('#imagen').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
             {
                var reader = new FileReader();

                reader.onload = function (e) {
                   $('#img_imagen').attr('src', e.target.result);
                }
               reader.readAsDataURL(input.files[0]);
            }
            else
            {
              alert("El archivo seleccionado debe ser una imagen")
              $('#img_imagen').attr('src', '{{ asset('imagenes/app/sinimagen.jpg') }}');
            }
            $('#nombre_archivo').html("Examinar")
          });
    })
</script>
@endsection