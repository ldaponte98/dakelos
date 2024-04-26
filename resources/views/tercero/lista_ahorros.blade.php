<div class="row">
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
                            <th>Valor</th>
                            <th>Saldo</th>
                            <th>Utilizada</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $cont = 1; @endphp
                        @foreach ($facturas as $factura)
                            @if ($factura->id_dominio_tipo_factura == \App\Dominio::get('Recibo de caja'))
                                @php
                                    $facturas_donde_han_usado_ahorro = $factura->facturas_donde_han_usado_ahorro();
                                    $cont = 0;
                                @endphp
                                <tr>
                                    <td class="serial">{{ $cont }}</td>
                                    <td>{{ $factura->numero }}</td>
                                    <td> {{ date('Y-m-d H:i', strtotime($factura->fecha)) }} </td>
                                    <td> {{ $factura->usuario_registra->tercero->nombre_completo() }} </td>
                                    <td>${{ number_format($factura->valor_original, 0, '.', '.') }}</td>
                                    <td>${{ number_format($factura->valor, 0, '.', '.') }}</td>
                                    <td>
                                        @if (count($facturas_donde_han_usado_ahorro) == 0)
                                            <span>No</span>
                                        @else
                                            @foreach ($facturas_donde_han_usado_ahorro as $item)
                                                @if ($cont > 0)
                                                    <br>
                                                @endif
                                                <a target="_blank" href="{{ route('factura/imprimir', $item->id_factura) }}">{{ $item->numero }} </a>
                                                @php
                                                    $cont++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <center>{{ $factura->get_estado() }}</center>
                                    </td>
                                    <td>
                                        <center>
                                            <a target="_blank"
                                                href="{{ route('factura/imprimir', $factura->id_factura) }}">Ver
                                                detalles</a>
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
