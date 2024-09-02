<div class="row">
<div class="col-12">
    <div class="form-group">
        <label for="correo"
            class="control-label mb-1"><b>Buscar</b></label>
        <input id="filtro" type="search" class="form-control">
    </div>
</div>
	<div class="col-lg-12">
            <div class="card">
                <div class="table-stats order-table ov-h">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th class="serial">#</th>
                                <th>Numero</th>
                                <th>Fecha</th>
                                <th>Medico</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="bodytable">
                        	@php $cont = 1; @endphp
                        	@foreach($historias as $historia)
                        	<tr>
                                <td class="serial">{{ $cont }}</td>
                                <td> HC-{{ $historia->id }}</td>
                                <td> {{ date('Y-m-d H:i' ,strtotime($historia->created_at)) }} </td>
                                <td> {{ $historia->profesional->nombres }} </td>
                                <td>
                                    <center>
                                    	<a target="_blank" href="{{ route('clinica/historiaClinica/imprimir_historia', $historia->id) }}">Ver hiistoria</a>
                                    </center>
                                </td>
                            </tr>
                            @php $cont++; @endphp
                        	@endforeach
                        </tbody>
                    </table>
                </div> 
            </div>
    </div>
</div>