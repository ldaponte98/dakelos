@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Nueva historia clinica</strong>
            </div>
            <div id="pay-invoice">
                <form id="form-guardar-historia_clinica" method="POST">
                    {!! csrf_field() !!}
                    <div class="card-body">
                        <div class="container mt-4">
                            <!-- Pestañas -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active p-2" id="datos_personales-tab" data-toggle="tab"
                                        href="#datos_personales" role="tab" aria-controls="tab1"
                                        aria-selected="false">Datos Personales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="antecedentes-tab" data-toggle="tab" href="#antecedentes"
                                        role="tab" aria-controls="tab2" aria-selected="false">Antecedentes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="historia-tab" data-toggle="tab" href="#historia"
                                        role="tab" aria-controls="tab3" aria-selected="false">Historia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="plan-tab" data-toggle="tab" href="#plan" role="tab"
                                        aria-controls="tab4" aria-selected="false">Plan</a>
                                </li>
                            </ul>
                            <!-- Contenido de las pestañas -->
                            <div class="tab-content mt-4" id="myTabContent">
                                <div class="tab-pane fade show active" id="datos_personales" role="tabpanel"
                                    aria-labelledby="datos_personales-tab">
                                    <div class="card-title">
                                        <h3 class="text-center">Datos personales</h3>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="identificacion"
                                                class="control-label mb-1"><b>Identificación</b></label>
                                            <input disabled value="{{$agenda->tercero->identificacion}}" type="text"
                                                id="identificacion" name="tercero[identificacion]" class="form-control">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="nombres" class="control-label mb-1"><b>Paciente</b></label>
                                            <input disabled
                                                value="{{$agenda->tercero->nombres}} {{$agenda->tercero->apellidos}}"
                                                type="text" id="nombres" name="tercero[nombres]" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="genero" class="control-label mb-1"><b>Genero</b></label>
                                            <input disabled value="{{$tipo_sexo->nombre}}" type="text" id="genero"
                                                name="tercero[genero]" class="form-control">
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="telefono" class="control-label mb-1"><b>Teléfono</b></label>
                                            <input disabled value="{{$agenda->tercero->telefono}}" type="text"
                                                id="telefono" name="tercero[telefono]" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="fecha_nacimiento" class="control-label mb-1"><b>Fecha de
                                                    Nacimiento</b></label>
                                            <input disabled value="{{$agenda->tercero->fecha_nacimiento}}" type="date"
                                                id="fecha_nacimiento" name="tercero[fecha_nacimiento]"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="edad" class="control-label mb-1"><b>Edad</b></label>
                                            <div class="input-group">
                                                <input disabled value="{{$agenda->tercero->get_edad()}}" type="text"
                                                    id="edad" class="form-control" aria-required="true"
                                                    aria-invalid="false">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="edad">Años</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="antecedentes" role="tabpanel"
                                    aria-labelledby="antecedentes-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_familiar"
                                                class="control-label"><b>Familiares</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_familiar"
                                                name="antecedente[familiar]">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->antecedente_familiar}}@endif</textarea>

                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_personales"
                                                class="control-label"><b>Personales</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_personales"
                                                name="antecedente[personal]">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->antecedente_personal}}@endif</textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_gineco-obstetricos"
                                                class="control-label"><b>Gineco-obstétricos</b></label>
                                            <textarea class="w-100 form-control" type="text"
                                                id="antecedente_gineco-obstetrico"
                                                name="antecedente[gineco-obstetrico]">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->antecedente_gineco_obstetrico}}@endif</textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_cirugia"
                                                class="control-label"><b>Cirugia</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_cirugia"
                                                name="antecedente[cirugia]">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->antecedente_cirugia}}@endif</textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_medicamentos"
                                                class="control-label"><b>Medicamentos</b></label>
                                            <textarea class="w-100 form-control" cols="50" type="text"
                                                id="antecedente_medicamentos"
                                                name="antecedente[medicamentos]">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->antecedente_medicamentos}}@endif</textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_alergias" class="control-label"><b>FUM
                                                    Alergias</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_alergias"
                                                name="antecedente[alergias]">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->antecedente_alergias}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="historia" role="tabpanel" aria-labelledby="historia-tab">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 form-group mb-25">
                                            <label for="motivo" class="control-label"><b>*Descripcion</b></label>
                                            <textarea class="w-100 form-control" rows="10" type="text" id="motivo"
                                                name="motivo">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->motivo}}@endif</textarea>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="tension" class="control-label mb-1"><b>Tension</b></label>
                                            <div class="input-group mb-3">
                                                <input name="tension" type="text" class="form-control"
                                                    aria-required="true" aria-invalid="false">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="tension">mmHg</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="peso" class="control-label mb-1"><b>Peso</b></label>
                                            <div class="input-group mb-3">
                                                <input name="peso" type="number" min="0" class="form-control"
                                                    aria-required="true" aria-invalid="false">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="peso">Kg</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="plan" role="tabpanel" aria-labelledby="plan-tab">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 form-group">
                                            <label for="plan" class="control-label"><b>Plan</b></label>
                                            <textarea class="w-100 form-control" rows="5" type="text" id="plan"
                                                name="plan">@if ($historia_anterior == null)</textarea>@else{{$historia_anterior->plan}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal envio de historia --}}

                        <div class="modal fade" id="confirmar" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Enviar Historia</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">x</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="correo" class="control-label mb-1"><b>Correo</b></label>
                                                    <input disabled value="{{$agenda->tercero->email}}" type="email"
                                                        id="correo" name="tercero[correo]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="envio_correo"
                                                        name="envio_correo">
                                                    <label class="form-check-label" for="envio_correo">
                                                        Enviar al correo
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button type="button" id="btn-guardar"
                                                    class="btn btn-primary">Aceptar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button id="btn-confirmar" type="button" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-confirmar').addEventListener("click", function() {

        if($("#motivo").val().trim() == ""){
            let posicion = $('#historia-tab').offset().top;
            $('#historia-tab').tab('show');
            $('html, body').animate({
                scrollTop: posicion
            }, 800); // 
            return toastr.error("El motivo de la consulta es obligatoria", "Error");
        }
        
        $("#confirmar").modal("show");
    });

    document.getElementById('btn-guardar').addEventListener("click", function() {
        Loading(true, "Guardando historia clinica");
        $('#form-guardar-historia_clinica').submit()
    });

</script>
@endsection