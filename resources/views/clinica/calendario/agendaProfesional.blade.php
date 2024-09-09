@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Mis agendas</strong>
                </div>

            @if (session('status'))
                <script>
                    toastr.success(" {{ session('status') }}", "Proceso exitoso");
                </script>
            @endif

                    <div id="pay-invoice"> 
                        <!-- Modal -->
                        <div class="modal fade" id="evento" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <form id="form-agenda-profesional">
                                {!! csrf_field() !!}
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
                                                <input id="id_agenda" name="id_agenda" type="hidden">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="profesional" class="control-label"><b>*Profesional</b></label>
                                                        <input @readonly(true) value="{{$profesionales->nombres}} {{$profesionales->apellidos}}" type="text" id="modal-profesional" name="modal-profesional" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="title" class="control-label mb-1"><b>*Motivo de consulta</b></label>
                                                        @php
                                                            $motivo_consulta = \App\Dominio::all()->where('id_padre', 70);
                                                        @endphp
                                                        <select @readonly(true) id="title" name="title" class="form-control" required>
                                                            @foreach ($motivo_consulta as $motivo)
                                                                <option disabled selected title="{{$motivo->descripcion}}" value="{{ $motivo->nombre }}">{{ $motivo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="start" class="control-label mb-1"><b>Fecha
                                                                Inicio</b></label>
                                                        <input type="text" id="start" name="start" class="form-control datetimepicker" autocomplete="off" disabled>
                                                    </div>
                                                </div>

                                                <h6 class="col-12 border-bottom my-4 text-center"><b>Datos del paciente</b></h6>
                                                <br>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="identificacion"
                                                            class="control-label mb-1"><b>Identificación</b></label>
                                                        <input @readonly(true) type="text" id="identificacion" name="tercero[identificacion]" class="form-control" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="nombres"
                                                            class="control-label mb-1"><b>Paciente</b></label>
                                                        <input type="text" id="nombres" name="tercero[nombres]" class="form-control" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="id_dominio_sexo"
                                                            class="control-label mb-1"><b>Genero</b></label>
                                                        @php
                                                            $tipos_sexo = \App\Dominio::all()->where('id_padre', 12);
                                                        @endphp
                                                        <select id="genero" name="tercero[id_dominio_sexo]" class="form-control" required>
                                                            @foreach ($tipos_sexo as $tipo_sexo)
                                                                <option disabled selected value="{{ $tipo_sexo->id_dominio }}">
                                                                    {{ $tipo_sexo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="telefono"
                                                            class="control-label mb-1"><b>Teléfono</b></label>
                                                        <input type="text" id="telefono" name="tercero[telefono]" class="form-control" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="correo"
                                                            class="control-label mb-1"><b>Correo</b></label>
                                                        <input type="email" id="correo" name="tercero[correo]" class="form-control" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="observaciones"
                                                            class="control-label"><b>Observaciones</b></label>
                                                            <textarea class="w-100 form-control" type="text" id="observaciones" name="observaciones" disabled></textarea >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button  style="display: none;" type="button" id="btn-atender" class="btn btn-primary">Atender</button>
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
    {{ view('clinica.calendario.script-agendaProfesional') }}
@endsection
