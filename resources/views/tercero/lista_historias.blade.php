<div class="row">
<div class="col-12">
    <div class="form-group">
        <input id="filtro_historia" type="search" class="form-control" placeholder="Buscar..."> 
    </div>
</div>
	<div class="col-lg-12">
            <div class="card">
                <div class="table-stats order-table ov-h">
                    <table id="tabla_historia" class="table" >
                        <thead>
                            <tr>
                                <th class="serial">#</th>
                                <th>Numero</th>
                                <th>Fecha</th>
                                <th>Medico</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        	@php $cont = 1; @endphp
                        	@foreach($historias as $historia)
                            @if($historia->estado == 1)
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
                            @endif
                            @php $cont++; @endphp
                        	@endforeach
                        </tbody>
                    </table>
                </div> 
            </div>
    </div>
</div>

<script>
    $(document).ready(()=>{
        setFiltro('filtro_historia', 'tabla_historia');
    })
</script>