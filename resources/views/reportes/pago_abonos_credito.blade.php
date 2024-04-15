@extends('layout.main')
@section('menu')
    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fa fa-bars"></i>
        </div>
        <ul class="fab-options">
            <li onclick="exportar_excel()">
                <span class="fab-label">Exportar a excel</span>
                <div class="fab-icon-holder">
                    <i class="ti-agenda"></i>
                </div>
            </li>
        </ul>
    </div>
@endsection
@section('content')
<style>
    .chosen-container{
        width: 83% !important;
    }
    .chosen-container-multi .chosen-choices {
        padding: .3rem .75rem;
        border-radius: .25rem;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-9" style="padding-top: 7px;">
                        <strong>Documento <a href=""></a>{{ $documento->numero }}</strong>
                    </div>
                    <div class="col-sm-3" style="text-align: right !important;">
                        <input id="filtro" type="text" class="form-control" placeholder="Consulte aqui..." autocomplete="on">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered ">
                            <tr>
                                <td width="30%"><b>Numero</b></td>
                                <td>{{ $documento->numero }}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha</b></td>
                                <td>{{ date('Y-m-d H:i', strtotime($documento->created_at)) }}</td>
                            </tr>
                            <tr>
                                <td><b>Titular</b></td>
                                <td>{{ $documento->tercero->nombre_completo() }}</td>
                            </tr>
                            <tr>
                                <td><b>Tipo de documento</b></td>
                                <td>{{ $documento->tipo->nombre }}</td>
                            </tr>
                            <tr>
                                <td><b>Valor original</b></td>
                                <td>${{ number_format($documento->valor_original, 0, '.', '.') }}</td>
                            </tr>
                            @if ($documento->credito_comprobante_egreso == 1)
                                <tr>
                                    <td><b>Valor abono inicial</b></td>
                                    <td>${{ number_format($documento->abono_inicial, 0, '.', '.') }}</td>
                                </tr>
                                <tr>
                                    @php
                                        $forma_pago_abono = \App\Dominio::find($documento->id_dominio_forma_pago_abono_inicial);
                                    @endphp
                                    <td><b>Forma de pago de abono inicial</b></td>
                                    <td>{{ $forma_pago_abono != null ? $forma_pago_abono->nombre : "Ninguna" }}</td>
                                </tr>
                                <tr>
                                    <td><b>Pendiente por pagar</b></td>
                                    <td>${{ number_format($documento->valor, 0, '.', '.') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-9" style="padding-top: 7px;">
                        <strong>Documentos asociados</strong>
                    </div>
                    <div class="col-sm-3" style="text-align: right !important;">
                        <input id="filtro" type="text" class="form-control" placeholder="Consulte aqui..." autocomplete="on">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-stats order-table ov-h ">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial"><center><b>#</b></center></th>
                                        <th><center><b>Numero</b></center></th>
                                        <th><center><b>Tercero</b></center></th>
                                        <th><center><b>Fecha</b></center></th>
                                        <th><center><b>Usu registro</b></center></th>
                                        <th><center><b>Valor original</b></center></th>
                                        <th><center><b>Estado</b></center></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">
                                    @php $cont = 1; @endphp
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($facturas as $factura)
                                    <tr>
                                        <td class="serial"><center>{{ $cont }}</center></td>
                                        <td><center><a href="{{ route('factura/imprimir', $factura->id_factura) }}">{{ $factura->numero }}</a></center></td>
                                        <td><center><a href="{{ route('tercero/view', $factura->id_tercero) }}">{{ $factura->tercero->nombre_completo() }}</a></center></td>
                                        <td><center> {{ date('Y-m-d H:i' ,strtotime($factura->fecha)) }} </center></td>
                                        <td><center> {{ $factura->usuario_registra->tercero->nombre_completo() }} </center></td>
                                        <td><center>
                                        @if ($factura->estado == 1)
                                            <span class="badge badge-success">
                                                <b>{{ $factura->get_estado() }}</b>
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <b style="cursor: pointer;" title="{{ $factura->motivo_anulacion }}">{{ $factura->get_estado() }}</b>
                                            </span>
                                        @endif    
                                        </center></td>
                                        <td><center>${{ number_format($factura->valor_original, 0, '.', '.') }}</center></td>
                                        @php 
                                            $total += $factura->valor_original;
                                        @endphp
                                    </tr>
                                    @php $cont++; @endphp
                                    @endforeach

                                    @if (count($facturas) == 0)
                                        <tr>
                                            <td colspan="7">
                                                <center>
                                                    <br>
                                                    <i>No hay registros para esta consulta</i>
                                                    <br>
                                                </center>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="6"> 
                                                <b><label>Total</label></b>
                                            </td>
                                            <td><center>${{ number_format($total, 0, '.', '.') }}</center></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table border="1" id="tabla_excel" style="display: none">
    <tr>
        <td colspan='9' rowspan='2'>
            <center>
                <b>REPORTE DE FACTURAS ASOCIADAS A DOCUMENTO {{ $documento->numero }}</b>
            </center>
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Numero</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Tercero</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Fecha</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Cantidad de productos</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Usu registro</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Estado</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Valor original</b></td>
    </tr>
    <tbody id="bodytable_excel">
        @php
            $total = 0;
        @endphp
            @foreach($facturas as $factura)
             <tr>
                <td>{{ $factura->numero }}</td>
                <td>{{ $factura->tercero->nombre_completo() }}</td>
                <td>{{ date('Y-m-d H:i' ,strtotime($factura->fecha)) }} </td>
                <td>{{ count($factura->detalles) }} </td>
                <td>{{ $factura->usuario_registra->tercero->nombre_completo() }} </td>
                <td><center>{{ $factura->estado == 1 ? "Activa" : "Inactiva" }}</center></td>
                <td>{{ $factura->valor_original }}</td>
            </tr>
            @php
                $total += $factura->valor;
            @endphp
            @endforeach
            <tr>
                <td colspan="6"><b>Total</b></td>
                <td colspan="1" style="text-align: right;"><b>{{ $total }}</b></td>
            </tr>
    </tbody>    
</table>
@endsection