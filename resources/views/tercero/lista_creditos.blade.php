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
                                <th>Usu registro</th>
                                <th>Valor original</th>
                                <th>Valor pendiente</th>
                                <th>Estado</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="bodytable">
                        	@php $cont = 1; @endphp
                        	@foreach($facturas as $factura)
                        	@if($factura->id_dominio_tipo_factura == \App\Dominio::get("Factura a credito (Saldo pendiente)"))
                        	   <tr>
                                    <td class="serial">{{ $cont }}</td>
                                    <td>{{ $factura->numero }}</td>
                                    <td> {{ date('Y-m-d H:i' ,strtotime($factura->fecha)) }} </td>
                                    <td> {{ $factura->usuario_registra->tercero->nombre_completo() }} </td>
                                    <td>${{ number_format($factura->valor_original, 0, '.', '.') }}</span></td>
                                    <td>${{ number_format($factura->valor, 0, '.', '.') }}</span></td>
                                    <td><center>{{ $factura->get_estado() }}</center></td>
                                    <td>
                                        <center>
                                            <a target="_blank" href="{{ route('factura/imprimir', $factura->id_factura) }}">Ver detalles</a>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <a target="_blank" href="{{ route('reportes/documentos-asociados-factura', $factura->id_factura) }}">Abonos</a>
                                        </center>
                                    </td>
                                </tr>
                            @php $cont++; @endphp
                            @endif
                        	@endforeach
                          
                        </tbody>
                    </table>
                </div> 
            </div>
    </div>
</div>