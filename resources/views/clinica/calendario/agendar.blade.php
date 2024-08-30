@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Agendamiento de citas</strong>
                </div>
                    <div id="pay-invoice"> 
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">Agendamiento de citas</h3>
                            </div>
                            <hr>
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="profesional" class="control-label"><b>*Profesional</b></label>
                                        @php
                                            $profesionales = \App\Tercero::all()->where('id_dominio_tipo_tercero', 69);
                                        @endphp
                                        <select name="profesional" id="profesional" class="form-control" required>
                                            <option selected disabled value="">Seleccione...</option>
                                            @foreach ($profesionales as $items)
                                                <option class="h6" value="{{ $items->id_tercero }}">
                                                    {{ $items->nombres }}
                                                    {{ $items->apellidos }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 d-flex justify-content-end mt-2">
                                    <button  type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#evento">
                                        + Nueva
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="evento" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <form id="form-citas">
                                {{!! csrf_field() !!}}
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Agendar cita</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">x</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <input id="id_cita" name="id_cita" type="hidden">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="profesional" class="control-label"><b>*Profesional</b></label>
                                                        @php
                                                            $profesionales = \App\Tercero::all()->where('id_dominio_tipo_tercero', 69);
                                                        @endphp
                                                        <select name="modal-profesional" id="modal-profesional" class="form-control" required>
                                                            @foreach ($profesionales as $items)
                                                                <option  class="h6" value="{{ $items->id_tercero }}">
                                                                    {{ $items->nombres }}
                                                                    {{ $items->apellidos }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="title" class="control-label mb-1"><b>*Motivo de consulta</b></label>
                                                        @php
                                                            $motivo_consulta = \App\Dominio::all()->where('id_padre', 70);
                                                        @endphp
                                                        <select id="title" name="title" class="form-control" required>
                                                            @foreach ($motivo_consulta as $motivo)
                                                                <option title="{{$motivo->descripcion}}" value="{{ $motivo->nombre }}">{{ $motivo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="start" class="control-label mb-1"><b>Fecha
                                                                Inicio</b></label>
                                                        <input type="text" id="start" name="start" class="form-control datetimepicker" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="end" class="control-label mb-1"><b>Fecha
                                                                final</b></label>
                                                        <input type="text" id="end" name="end"  class="form-control datetimepicker" autocomplete="off">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12 col-sm-12 mt-2">
                                                    <label for="validationCustom01" class="form-label"><b>Días<span class="required">*</span></b></label>
                                                    <select class="form-select property select2" multiple id="days" name="days[]" placeholder="Seleccione">
                                                        <option selected value="all">Todos los dias</option>
                                                        <option value="monday">Lunes</option>
                                                        <option value="tuesday">Martes</option>
                                                        <option value="wednesday">Miercoles</option>
                                                        <option value="thursday">Jueves</option>
                                                        <option value="friday">Viernes</option>
                                                        <option value="saturday">Sabado</option>
                                                        <option value="sunday">Domingo</option>
                                                    </select>
                                                </div>

                                                <h6 class="col-12 border-bottom my-4 text-center"><b>Datos del paciente</b></h6>
                                                <br>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="id_dominio_tipo_identificacion" class="control-label mb-1"><b>*Tipo de
                                                                identificación</b></label>
                                                        @php
                                                            $tipos_identificacion = \App\Dominio::all()->where('id_padre', 4);
                                                        @endphp
                                                        <select id="tipo_identificacion" name="tercero[id_dominio_tipo_identificacion]" class="form-control" required>
                                                            @foreach ($tipos_identificacion as $tipo)
                                                                <option title="{{$tipo->descripcion}}" value="{{ $tipo->id_dominio }}">{{ $tipo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="identificacion"
                                                            class="control-label mb-1"><b>Identificación</b></label><div id="modal-search-loading" style="display: none;" class="loader"></div>
                                                        <input onkeyup="if(event.keyCode == 13) buscarPersona(this.value)" onchange="buscarPersona(this.value)" type="text" id="identificacion" name="tercero[identificacion]" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="nombres"
                                                            class="control-label mb-1"><b>*Nombres</b></label>
                                                        <input type="text" id="nombres" name="tercero[nombres]" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="apellidos"
                                                            class="control-label mb-1"><b>Apellidos</b></label>
                                                        <input type="text" id="apellidos" name="tercero[apellidos]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="id_dominio_sexo"
                                                            class="control-label mb-1"><b>*Genero</b></label>
                                                        @php
                                                            $tipos_sexo = \App\Dominio::all()->where('id_padre', 12);
                                                        @endphp
                                                        <select id="genero" name="tercero[id_dominio_sexo]" class="form-control" required>
                                                            @foreach ($tipos_sexo as $tipo_sexo)
                                                                <option value="{{ $tipo_sexo->id_dominio }}">
                                                                    {{ $tipo_sexo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="telefono"
                                                            class="control-label mb-1"><b>Teléfono</b></label>
                                                        <input type="text" id="telefono" name="tercero[telefono]" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="correo"
                                                            class="control-label mb-1"><b>Correo</b></label>
                                                        <input type="email" id="correo" name="tercero[correo]" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="observaciones"
                                                            class="control-label"><b>Observaciones</b></label>
                                                            <textarea class="w-100 form-control" type="text" id="observaciones" name="observaciones"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button type="button" id="btn-guardar" class="btn btn-primary">Guardar</button>
                                                <button style="display: none;" type="button" id="btn-cancelar" class="btn btn-danger">Cancelar cita</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                
                <div class="p-4" id='calendar'></div>
            </div>
        </div>
    </div>
    {{ view('clinica.calendario.script-calendario') }}
@endsection
