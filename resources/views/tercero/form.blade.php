@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Datos del tercero</strong>
            </div>
            <div class="card-body">
                <!-- Credit Card -->
                <div id="pay-invoice">
                    <div class="card-body">
                        {{ Form::open(array('method' => 'post' ,'files' => true)) }}
                        <div class="card-title">
                            <h3 class="text-center">@if($tercero->id_tercero == null) Crear tercero @else Modificar tercero @endif</h3>
                        </div><hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <img src="@if($tercero->imagen == null or $tercero->imagen == '') {{ asset('plantilla/images/app/user.jpg') }} @else {{ asset('imagenes/tercero/'.$tercero->imagen) }} @endif" id="img_imagen" alt="image" class="img-thumbnail" width="100%" height="200">
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
                                                <label for="cc-payment" class="control-label mb-1"><b>*Nombres</b></label>
                                                <input name="nombres" type="text" class="form-control" aria-required="true" required aria-invalid="false" value="{{ $tercero->nombres }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Apellidos</b></label>
                                                <input name="apellidos" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{ $tercero->apellidos }}">
                                            </div>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>*Tipo de identificación</b></label>
                                                @php
                                                    $tipos_identificacion = \App\Dominio::all()->where('id_padre', 4);
                                                @endphp
                                                <select name="id_dominio_tipo_identificacion" class="form-control" required>
                                                    @foreach($tipos_identificacion as $tipo)
                                                        <option @if($tercero->id_dominio_tipo_identificacion == $tipo->id_dominio) selected @endif value="{{ $tipo->id_dominio }}">{{ $tipo->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Identificación</b></label>
                                                <input name="identificacion" type="number" class="form-control" aria-required="true" aria-invalid="false" value="{{ $tercero->identificacion }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Correo electrónico</b></label>
                                                <input name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" value="{{ $tercero->email }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>*Genero</b></label>
                                                @php
                                                    $tipos_sexo = \App\Dominio::all()->where('id_padre', 12);
                                                @endphp
                                                <select name="id_dominio_sexo" class="form-control" required>
                                                    @foreach($tipos_sexo as $tipo_sexo)
                                                        <option @if($tercero->id_dominio_sexo == $tipo_sexo->id_dominio) selected @endif value="{{ $tipo_sexo->id_dominio }}">{{ $tipo_sexo->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                               <label for="fecha_nacimiento" class="control-label mb-1"><b>Fecha de nacimiento</b></label>
                                               <input name="fecha_nacimiento" type="date" class="form-control" aria-required="true" aria-invalid="false" value="{{ $tercero->fecha_nacimiento }}">
                                           </div>
                                       </div>
                                       <div class="col-sm-6">
                                        <div class="form-group">
                                           <label for="cc-payment" class="control-label mb-1"><b>Dirección</b></label>
                                           <input name="direccion" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{ $tercero->direccion }}">
                                       </div>
                                   </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                               <label for="cc-payment" class="control-label mb-1"><b>Telefono</b></label>
                                               <input name="telefono" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{ $tercero->telefono }}">
                                           </div>
                                       </div>
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>*Tipo tercero</b></label>
                                                @php
                                                    $tipos_tercero = \App\Dominio::all()->where('id_padre', 1);
                                                @endphp
                                                <select name="id_dominio_tipo_tercero" id="id_dominio_tipo_tercero" class="form-control" required>
                                                    <option value="">Seleccione...</option>
                                                    @foreach($tipos_tercero as $tipo)
                                                        <option @if($tercero->id_dominio_tipo_tercero == $tipo->id_dominio) selected @endif  
                                                            @if($tercero->id_dominio_tipo_tercero == null and $tipo->id_dominio == 3) selected @endif value="{{ $tipo->id_dominio }}">{{ $tipo->nombre }}</option>
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
                                                   <option @if($tercero->estado == 0) selected @endif value="0">Inactivo</option>
                                                   <option @if($tercero->estado == 1 || $tercero->id_tercero == null) selected @endif value="1">Activo</option>
                                               </select>
                                           </div>
                                       </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3" id="div-firma" style="display: none">
                                            <div class="form-group">
                                                <img src="@if($tercero->imagen_firma == null or $tercero->imagen_firma == '') {{ asset('plantilla/images/app/avatarFirma.png') }} @else {{ asset('imagenes/tercero/'.$tercero->imagen_firma) }} @endif" id="img_imagen_firma" alt="Firma" class="img-thumbnail" width="100%" height="100">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="imagen_firma" name="imagen_firma" accept="image/*">
                                                    <label class="custom-file-label" for="imagen_firma" id="nombre_archivo_firma">Examinar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                        
                                <div>
            
                                <center>
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
        </div>
    </div>
</div>
 <script>

    $(document).ready(function(){
         $('#imagen').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")){
                var reader = new FileReader();

                reader.onload = function (e) {
                   $('#img_imagen').attr('src', e.target.result);
                }
               reader.readAsDataURL(input.files[0]);
            }else{
              alert("El archivo seleccionado debe ser una imagen")
              $('#img_imagen').attr('src', '{{ asset('imagenes/app/sinimagen.jpg') }}');
            }
            $('#nombre_archivo').html("Examinar")
          });


        if($('#id_dominio_tipo_tercero').val() == 69){
            $('#div-firma').show()
        }else{
            $('#div-firma').hide()
        }

        $('#id_dominio_tipo_tercero').change(function(){
            let tipo = $(this).val();
            if(tipo==69){
                $('#div-firma').show()
            }else{
                $('#div-firma').hide()
            }
        })


          $('#imagen_firma').change(function(){
            var input = this;
            var url = $(this).val();
            let size = input.size;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if(size < 2000){
                if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg")){
                    var reader = new FileReader();
    
                    reader.onload = function (e) {
                       $('#img_imagen_firma').attr('src', e.target.result);
                    }
                   reader.readAsDataURL(input.files[0]);
                }else{
                  alert("El archivo seleccionado debe ser una imagen")
                  $('#img_imagen_firma').attr('src', '{{ asset('imagenes/app/avatarFirma.png') }}');
                }
            }else{
                alert('El tamaño del archivo no debe superar los 2MB');
                $('#imagen_firma').val('');
                $('#img_imagen_firma').attr('src', '{{ asset('imagenes/app/avatarFirma.png') }}');
            }

            $('#nombre_archivo_firma').html("Examinar")
          });
    })
</script>
@endsection