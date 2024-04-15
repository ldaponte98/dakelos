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
                        <strong>Pago a proveedores</strong>
                    </div>
                    <div class="col-sm-3" style="text-align: right !important;">
                        <input id="filtro" type="text" class="form-control" placeholder="Consulte aqui..." autocomplete="on">
                    </div>
                </div>
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
                                    <input required name="fechas" id="fechas" type="text" class="form-control" placeholder="Todas" autocomplete="off" value="{{ $fechas }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="search_tercero">Proveedor</label>
                                    </div>
                                    <select name="search_tercero[]" data-placeholder="Escoje uno o mas..." multiple class="standardSelect">
                                        <option value="" label="default"></option>
                                        @foreach($proveedores as $item)
                                        <option @if(in_array($item->id_tercero, $search_tercero)) selected @endif value="{{ $item->id_tercero }}">{{ $item->nombre_completo() . " (".$item->identificacion.")" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Consultar</button>
                            </div>                            
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="col-sm-12">
                        <div class="table-stats order-table ov-h ">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial"><center><b>#</b></center></th>
                                        <th><center><b>Numero</b></center></th>
                                        <th><center><b>Proveedor</b></center></th>
                                        <th><center><b>Fecha</b></center></th>
                                        <th><center><b>Usu registro</b></center></th>
                                        <th><center><b>Valor original</b></center></th>
                                        <th><center><b>Abono inicial</b></center></th>
                                        <th><center><b>Pendiente por pagar</b></center></th>
                                        <th><center><b>Estado</b></center></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodytable">
                                    @php $cont = 1; @endphp
                                    @foreach($documentos as $factura)
                                        @php
                                            $estaPagada = $factura->estaPagada();
                                        @endphp
                                        <tr>
                                            <td class="serial"><center>{{ $cont }}</center></td>
                                            <td><center>{{ $factura->numero }}</center></td>
                                            <td><center><a target="_blank" href="{{ route('tercero/view', $factura->id_tercero) }}">{{ $factura->tercero->nombre_completo() }}</a></center></td>
                                            <td><center> {{ date('Y-m-d H:i' ,strtotime($factura->fecha)) }} </center></td>
                                            <td><center> {{ $factura->usuario_registra->tercero->nombre_completo() }} </center></td>
                                            <td><center>${{ number_format($factura->valor_original, 0, '.', '.') }}</center></td>
                                            <td><center>${{ number_format($factura->abono_inicial, 0, '.', '.') }}</center></td>
                                            <td><center>${{ number_format($factura->valor, 0, '.', '.') }}</center></td>
                                            <td><center>
                                                @if (!$estaPagada)
                                                    <span class="badge badge-warning">
                                                        <b>Sin pagar</b>
                                                    </span>
                                                @else
                                                    <span class="badge badge-success">
                                                        <b>Pagada</b>
                                                    </span>
                                                @endif
                                                
                                            </center></td>
                                            <td>
                                                <center>
                                                    <a target="_blank" href="{{ route('factura/imprimir', $factura->id_factura) }}" class="badge badge-info" target="_blank"> <i class="ti-printer icon" title="Imprimir factura formal"></i></a>
                                                    <a target="_blank" href="{{ route('reportes/documentos-asociados-factura', $factura->id_factura) }}"  class="badge badge-warning text-white pointer" > <i class="ti-server icon" title="Ver abonos"></i></a>
                                                    @if ($permiso_pagar and $factura->estado == 1 and !$estaPagada)
                                                        <a onclick="ModalPagar({{ $factura->id_factura }}, {{ $factura->valor }})" class="badge badge-success text-white pointer" > <i class="ti-money icon" title="Pagar o abonar"></i></a>
                                                    @endif
                                                </center>
                                            </td>
                                        </tr>
                                        @php $cont++; @endphp
                                    @endforeach

                                    @if (count($documentos) == 0)
                                        <tr>
                                            <td colspan="10">
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
                <br><br>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="table-stats ov-h">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><center><b>N° documentos</b></center></td>
                                        <td><center>{{ number_format($total_documentos, 0, ".", ".") }}</center></td>
                                    </tr>
                                    <tr>
                                        <td><center><b>Total acreditado</b></center></td>
                                        <td><center>${{ number_format($total_acreditado, 0, '.', '.') }}</center></td>
                                    </tr>
                                    <tr>
                                        <td><center><b>Pagado</b></center></td>
                                        <td><center>${{ number_format($total_pagado, 0, '.', '.') }}</center></td>
                                    </tr>
                                    <tr>
                                        <td><center><b>Pendiente por pagar</b></center></td>
                                        <td><center>${{ number_format($total_pendiente, 0, '.', '.') }}</center></td>
                                    </tr>
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
                <b>REPORTE DE PAGOS PENDIENTES A PROVEEDORES</b>
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
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Numero</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Proveedor</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Fecha</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Usu registro</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Estado</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Valor original</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Abono inicial</b></td>
        <td style="background-color: #094d96; color: #ffffff; width: 200px;"><b>Pendiente por pagar</b></td>
    </tr>
    <tbody id="bodytable_excel">
        @php
            $total = 0;
        @endphp
            @foreach($documentos as $factura)
                <tr>
                    <td>{{ $factura->numero }}</td>
                    <td>{{ $factura->tercero->nombre_completo() }}</td>
                    <td>{{ date('Y-m-d H:i' ,strtotime($factura->fecha)) }} </td>
                    <td>{{ $factura->usuario_registra->tercero->nombre_completo() }} </td>
                    <td><center>{{ $factura->estaPagada() ? "Pagada" : "Sin pagar" }}</center></td>
                    <td>{{ $factura->valor_original }}</td>
                    <td>{{ $factura->abono_inicial }}</td>
                    <td>{{ $factura->valor }}</td>
                </tr>
                @php
                    $total += $factura->valor;
                @endphp
            @endforeach
            <tr>
                <td colspan="7"><b>Total</b></td>
                <td colspan="1" style="text-align: right;"><b>{{ $total }}</b></td>
            </tr>
    </tbody>    
</table>

@if ($permiso_pagar)
    <div class="modal fade" id="modal-pago" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel"><b>Pago de saldo pendiente</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Forma de pago</label>
                        <select id="modal-forma-pago" class="form-control">
                            @foreach($formas_pago as $item)
                                <option value="{{ $item->id_dominio }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label id="lb-modal-valor">Valor a pagar</label>
                        <input type="number" id="modal-valor" class="form-control"></input>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea rows="2" id="modal-observaciones" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Pagar()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script type="text/javascript">
    var id_factura = null;
    function exportar_excel() {
        tableToExcel('tabla_excel', 'Informe pagos pendientes a proveedores')
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

    @if ($permiso_pagar)
        function ModalPagar(id_factura, valor) {
            this.id_factura = id_factura; 
            $("#lb-modal-valor").html(`Valor a pagar (Max: $${valor})`)
            $("#modal-valor").val(valor)
            $('#modal-pago').modal('show');
        }
        function Pagar() {
            let observaciones = $("#modal-observaciones").val()
            let valor = $("#modal-valor").val()
            let forma_pago = $("#modal-forma-pago").val()

            let url = "{{ route('factura/pagar_proveedor') }}"
            Loading(true, "Pagando a proveedor...")
            var _token = ""
            $("[name='_token']").each(function() { _token = this.value })
            let request = {
                '_token' : _token,
                'id_factura' : id_factura,
                'valor' : valor,
                'observaciones' : observaciones,
                'forma_pago' : forma_pago
            }
            $.post(url, request, (response) => {
                if (!response.error) {
                    this.id_factura = null;
                    toastr.success(response.mensaje, "Proceso exitoso")
                    setTimeout(function() { location.reload() }, 1000);                
                }else{
                    Loading(false)
                    toastr.error(response.mensaje, "Error")
                }
            })
            .fail((error) => {
                console.log(error)
                toastr.error("Ha ocurrido un error, por favor intentelo nuevamente", "Error")
            })           
        }
    @endif
</script>
@endsection