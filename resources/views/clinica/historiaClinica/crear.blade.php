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
                        <div class="card-title">
                            <h3 class="text-center">Datos personales</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="identificacion" class="control-label mb-1"><b>Identificación</b></label>
                                <input disabled type="text" id="identificacion" name="tercero[identificacion]"
                                    class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="nombres" class="control-label mb-1"><b>Paciente</b></label>
                                <input disabled type="text" id="nombres" name="tercero[nombres]" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="genero" class="control-label mb-1"><b>Genero</b></label>
                                <input disabled type="text" id="genero" name="tercero[genero]" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="telefono" class="control-label mb-1"><b>Teléfono</b></label>
                                <input disabled type="text" id="telefono" name="tercero[telefono]" class="form-control">
                            </div>
                        </div>

                        <div class="container mt-4">
                            <!-- Pestañas -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item ">
                                    <a class="nav-link active p-2" id="tab1-tab" data-toggle="tab" href="#antecedentes" role="tab"
                                        aria-controls="tab1" aria-selected="true">Antecedentes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="tab2-tab" data-toggle="tab" href="#historia" role="tab"
                                        aria-controls="tab2" aria-selected="false">Historia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2" id="tab3-tab" data-toggle="tab" href="#plan" role="tab"
                                        aria-controls="tab3" aria-selected="false">Plan</a>
                                </li>
                            </ul>

                            <!-- Contenido de las pestañas -->
                            <div class="tab-content mt-4" id="myTabContent">
                                <div class="tab-pane fade show active" id="antecedentes" role="tabpanel"
                                    aria-labelledby="tab1-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_familiar"
                                                class="control-label"><b>Familiares</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_familiar"
                                                name="antecedente[familiar]"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_personales"
                                                class="control-label"><b>Personales</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_personales"
                                                name="antecedente[personales]"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_gineco-obstetricos"
                                                class="control-label"><b>Gineco-obstétricos</b></label>
                                            <textarea class="w-100 form-control" type="text"
                                                id="antecedente_gineco-obstetricos"
                                                name="antecedente[gineco-obstetricos]"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_cirugia"
                                                class="control-label"><b>Cirugia</b></label>
                                            <textarea class="w-100 form-control" type="text" id="antecedente_cirugia"
                                                name="antecedente[cirugia]"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_medicamentos"
                                                class="control-label"><b>Cirugia</b></label>
                                            <textarea class="w-100 form-control"cols="50" type="text"
                                                id="antecedente_medicamentos"
                                                name="antecedente[medicamentos]"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 form-group">
                                            <label for="antecedente_alergias"
                                                class="control-label"><b>FUM Alergias</b></label>
                                            <textarea class="w-100 form-control" type="text"
                                                id="antecedente_alergias"
                                                name="antecedente[alergias]"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="historia" role="tabpanel" aria-labelledby="tab2-tab">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 form-group">
                                            <label for="motivo"
                                                class="control-label"><b>*Motivo</b></label>
                                            <textarea class="w-100 form-control" type="text" id="motivo"
                                                name="motivo"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="plan" role="tabpanel" aria-labelledby="tab3-tab">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 form-group">
                                            <label for="plan"
                                                class="control-label"><b>Plan</b></label>
                                            <textarea class="w-100 form-control" type="text" id="plan"
                                                name="plan"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button id="btn-guardar" type="button" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btn-guardar').addEventListener("click", function() {

        if($("#motivo").val().trim() == ""){
            let posicion = $('#tab2-tab').offset().top;
            $('#tab2-tab').tab('show');
            $('html, body').animate({
                scrollTop: posicion
            }, 800); // 
            return toastr.error("El motivo de la consulta es obligatoria", "Error");
        }

        $('#form-guardar-historia_clinica').submit()

    });
</script>
@endsection
