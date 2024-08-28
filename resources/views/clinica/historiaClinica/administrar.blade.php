@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Nueva historia clinica</strong>
            </div>
            <div id="pay-invoice">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <form id="form-historia_clinica">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="identificacion" class="control-label mb-1"><b>Identificación</b></label>
                                <div class="d-flex">
                                    <input onkeyup="if(event.keyCode == 13) buscarPersona(this.value)"
                                        onchange="buscarPersona(this.value)" type="text" id="identificacion"
                                        name="identificacion" class="form-control">
                                    <div id="modal-search-loading" style="display: none;" class="loader"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 form-group">
                                <label for="nombres" class="control-label mb-1"><b>Paciente</b></label>
                                <input disabled type="text" id="nombres" name="tercero[nombres]" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button id="btn-nuevaHistoria" style="display: none;" type="button" class="btn btn-primary">
                                + Nueva historia
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function buscarPersona(caracter) { 
        if(caracter.length > 6){
            $("#modal-search-loading").css("display", "grid")
            let url = "{{ config('global.url_base') }}/tercero/buscar/" + caracter
            $.get(url, (res) => {
                $("#modal-search-loading").css("display", "none")
                if(res.length == 1){
                    const data = res[0]
                    $("#btn-nuevaHistoria").css("display", "block")
                    $("#identificacion").val(data.identificacion)
                    $("#nombres").val(data.nombres+ ' ' +data.apellidos)
                }
            }).fail((error) => {
                $("#modal-search-loading").css("display", "grid")
            })
        }
    }

    document.getElementById('btn-nuevaHistoria').addEventListener("click", function() {        
        $('#form-historia_clinica').submit()   
    });

</script>
@endsection