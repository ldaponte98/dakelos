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
<div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-cash"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text">$<span class="count">{{ $total_ventas }}</span></div>
                                            <div class="stat-heading">Total ventas</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="pe-7s-cart"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text">$<span class="count">{{ $total_ventas_fecha }}</span></div>
                                            <div class="stat-heading">@if($fechas=="") Ventas de hoy @else Ventas a la fecha @endif</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-browser"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">{{ $total_facturas_ventas }}</span></div>
                                            <div class="stat-heading">Facturas de venta</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">{{ $total_cotizaciones }}</span></div>
                                            <div class="stat-heading">Cotizaciones</div>
                                        </div>
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
                <strong class="card-title">Reporte de facturas</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::open(array('method' => 'post')) }}
                        <div class="row">
                            
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fechas">Fechas</label>
                                </div>
                                    <input name="fechas" id="fechas" type="text" class="form-control" placeholder="Lapso de tiempo de la factura" autocomplete="off" value="{{ $fechas }}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Consultar</button>
                            </div>
                            <div class="col-sm-3" style="text-align: right !important;">
                                <input id="filtro" type="text" class="form-control" placeholder="Consulte aqui..." autocomplete="on">
                            </div>
                            
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="col-lg-12">
                            <div class="card">
                                <div class="table-stats order-table ov-h">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="serial"><center><b>#</b></center></th>
                                                <th><center><b>Numero</b></center></th>
                                                <th><center><b>Cliente</b></center></th>
                                                <th><center><b>Fecha</b></center></th>
                                                <th><center><b>Tipo</b></center></th>
                                                <th><center><b>Usu registro</b></center></th>
                                                <th><center><b>Valor</b></center></th>
                                                <th><center><b>Estado</b></center></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodytable">
                                            @php $cont = 1; @endphp
                                            @foreach($facturas as $factura)
                                            <tr>
                                                <td class="serial">{{ $cont }}</td>
                                                <td>{{ $factura->numero }}</td>
                                                <td><a href="{{ route('tercero/view', $factura->id_tercero) }}">{{ $factura->tercero->nombre_completo() }}</a></td>
                                                <td> {{ date('Y-m-d H:i' ,strtotime($factura->fecha)) }} </td>
                                                <td> {{ $factura->tipo->nombre }} </td>
                                                <td> {{ $factura->usuario_registra->tercero->nombre_completo() }} </td>
                                                <td><span class="count">{{ $factura->valor }}</span></td>
                                                <td><center>{{ $factura->get_estado() }}</center></td>
                                                <td>
                                                    <center>
                                                        <a target="_blank" href="{{ route('factura/imprimir', $factura->id_factura) }}">Ver detalles</a>
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
            </div>
        </div> <!-- .card -->
    </div>
</div>

<table border="1" id="tabla_excel" style="display: none">
    <tr>
        <td colspan='8' rowspan='2'>
            <center>
                <b>REPORTE DE FACTURAS</b>
            </center>
        </td>
    </tr>
    <tr></tr>
     @if($fechas != "")
        <tr>
            <td colspan='8'><center><b>Fechas: </b>{{ $fechas }}</center></td>            
        </tr>
    @endif
    
    <tr>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Numero</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Cliente</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Fecha</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Tipo</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Cantidad de productos</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Usu registro</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Estado</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Valor</b></td>
        
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
                <td>{{ $factura->tipo->nombre }} </td>
                <td>{{ count($factura->detalles) }} </td>
                <td>{{ $factura->usuario_registra->tercero->nombre_completo() }} </td>
                <td><center>{{ $factura->get_estado() }}</center></td>
                <td>{{ $factura->valor }}</td>
                
            </tr>
            @php
            if($factura->id_dominio_tipo_factura == 16){
                $total += $factura->valor;
            }
            @endphp
            @endforeach
            <tr>
                <td colspan="8" style="text-align: right;">Facturas de venta: <b>{{ $total }}</b></td>
            </tr>
    </tbody>    
</table>

<script type="text/javascript">
        function exportar_excel() {
            tableToExcel('tabla_excel', 'Reporte_de_facturas')
       }
     $(document).ready(function() {
              $('#fechas').daterangepicker({
                  timePicker: true,
                  timePicker24Hour : true,
                  autoApply: true,
                  autoUpdateInput: true,
                  locale: {
                    format: 'YYYY/MM/DD HH:mm',
                    cancelLabel: 'Limpiar',
                    applyLabel: 'Establecer'
                  }
              });
              $('#fechas').val('{{ $fechas }}');

              $('#fechas').on('apply.daterangepicker', function(ev, picker) {
                  $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm') + ' - ' + picker.endDate.format('YYYY/MM/DD HH:mm'));
              });

              $('#fechas').on('cancel.daterangepicker', function(ev, picker) {
                  $(this).val('');
              });
            
        })
</script>
@endsection