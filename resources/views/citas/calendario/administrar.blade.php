@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Agendamiento de citas</strong>
                </div>
                <div class="card-body">
                    <div id="pay-invoice">
                        <div class="card-body">
                            {{ Form::open(['method' => 'post', 'files' => true]) }}
                            <div class="card-title">
                                <h3 class="text-center">Agendamiento de citas</h3>
                            </div>
                            <hr>
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="profesional" class="control-label"><b>*Profecional</b></label>
                                        @php
                                            $profesionales = \App\Tercero::all()->where('id_dominio_tipo_tercero', 69);
                                        @endphp
                                        <select name="profesional" class="form-control" required>
                                            @foreach ($profesionales as $items)
                                                <option class="h6" value="{{ $items->id_tercero }}">
                                                    {{ $items->nombres }}
                                                    {{ $items->apellidos }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 d-flex justify-content-end mt-2">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        + Nueva
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="profesional" class="control-label"><b>*Profecional</b></label>
                                                    @php
                                                        $profesionales = \App\Tercero::all()->where('id_dominio_tipo_tercero', 69);
                                                    @endphp
                                                    <select name="profesional" class="form-control" required>
                                                        @foreach ($profesionales as $items)
                                                            <option class="h6" value="{{ $items->id_tercero }}">
                                                                {{ $items->nombres }}
                                                                {{ $items->apellidos }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1"><b>Fecha
                                                            Inicio</b></label>
                                                    <input type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment" class="control-label mb-1"><b>Fecha
                                                            final</b></label>
                                                    <input type="date" class="form-control">
                                                </div>
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
                                                    <select name="id_dominio_tipo_identificacion" class="form-control" required>
                                                        @foreach ($tipos_identificacion as $tipo)
                                                            <option title="{{$tipo->descripcion}}" value="{{ $tipo->id_dominio }}">{{ $tipo->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment"
                                                        class="control-label mb-1"><b>Identificación</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment"
                                                        class="control-label mb-1"><b>*Nombres</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment"
                                                        class="control-label mb-1"><b>Apellidos</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment"
                                                        class="control-label mb-1"><b>*Genero</b></label>
                                                    @php
                                                        $tipos_sexo = \App\Dominio::all()->where('id_padre', 12);
                                                    @endphp
                                                    <select name="id_dominio_sexo" class="form-control" required>
                                                        @foreach ($tipos_sexo as $tipo_sexo)
                                                            <option value="{{ $tipo_sexo->id_dominio }}">
                                                                {{ $tipo_sexo->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment"
                                                        class="control-label mb-1"><b>Telefono</b></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="cc-payment"
                                                        class="control-label mb-1"><b>Correo</b></label>
                                                    <input type="email" class="form-control">
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
                                            <button type="button" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="p-4" id='calendar'></div>
            </div>
        </div>
    </div>
    {{ view('citas.calendario.script-calendario') }}
@endsection
