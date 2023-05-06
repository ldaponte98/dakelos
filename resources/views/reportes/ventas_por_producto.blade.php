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
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-8" style="padding-top: 7px;">
                        <strong>Reporte de ventas por producto</strong>
                    </div>
                    <div class="col-sm-4" style="text-align: right !important;">
                        <input id="filtro" type="text" class="form-control" placeholder="Consulte producto" autocomplete="on">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::open(array('method' => 'post')) }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="fechas">Fechas</label>
                                </div>
                                    <input required name="fechas" id="fechas" type="text" class="form-control" placeholder="Lapso de tiempo de la factura" autocomplete="off" value="{{ $fechas }}">
                                </div>
                            </div>
                            @php
                                $_tipos_factura = \App\Dominio::get_tipos_facturas();
                            @endphp
                            <div class="col-sm-6">
                                <div class="input-group mb-3 " style="display: -webkit-inline-box;">
                                    <select id="id_tipo_factura" name="id_tipo_factura" style="width: 100%" class="form-control">
                                        @foreach($_tipos_factura as $item)
                                            <option @if($item->id_dominio == $id_tipo_factura) selected @endif 
                                                value="{{ $item->id_dominio }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div> 
                            <div class="col-sm-4">
                                <center>
                                <button type="submit" class="btn btn-info mb-3"><i class="fa fa-search"></i> Consultar</button>
                            </center>
                            </div>                            
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="col-sm-12">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial"><center><b>#</b></center></th>
                                        <th><center><b>Producto</b></center></th>
                                        <th><center><b>Cantidad</b></center></th>
                                        <th><center><b>Total</b></center></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">
                                    @php $cont = 1; @endphp
                                    @foreach($reporte as $rep)
                                    <tr>
                                        <td class="serial"><center>{{ $cont }}</center></td>
                                        <td><center>{{ $rep->producto }}</center></td>
                                        <td><center>{{ $rep->cantidad }} </center></td>
                                        <td><center>${{ number_format($rep->total, 0, '.', '.') }}</center></td>
                                    </tr>
                                    @php $cont++; @endphp
                                    @endforeach

                                    @if (count($reporte) == 0)
                                        <tr>
                                            <td colspan="8">
                                                <center>
                                                    <br>
                                                    <i>No hay registros para esta consulta</i>
                                                    <br>
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div> <!-- .card -->
    </div>
</div>

<table border="1" id="tabla_excel" style="display: none">
    <tr>
        <td colspan='9' rowspan='2'>
            <center>
                <b>REPORTE DE VENTAS POR PRODUCTO</b>
            </center>
        </td>
    </tr>
    <tr></tr>
     @if($fechas != "")
        <tr>
            <td colspan='9'><center><b>Fechas: </b>{{ $fechas }}</center></td>            
        </tr>
    @endif
    
    <tr>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Producto</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Cantidad</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Total</b></td> 
    </tr>
    <tbody id="bodytable_excel">
        @foreach($reporte as $rep)
            <tr>
                <td class="serial"><center>{{ $cont }}</center></td>
                <td><center>{{ $rep->producto }}</center></td>
                <td><center>{{ $rep->cantidad }} </center></td>
                <td><center>${{ number_format($rep->total, 0, '.', '.') }}</center></td>
            </tr>
            @php $cont++; @endphp
        @endforeach
    </tbody>    
</table>

<script type="text/javascript">
    var id_factura = null;
    function exportar_excel() {
        tableToExcel('tabla_excel', 'Informe Ventas por producto ARSI')
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