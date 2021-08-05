@php
    $licencia = \App\Licencia::find(session('id_licencia'));
@endphp
@extends('layout.main')
@section('menu')
    <div class="fab-container">
        <div class="fab fab-icon-holder" style="background: #23558a;">
            <i class="fa fa-floppy-o"></i>
        </div>
    </div>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('scroll-tabs/jquery.scrolling-tabs.css') }}" />
<link rel="stylesheet" href="{{ asset('scroll-tabs/st-demo.css') }}" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
	.d-flex{
		align-items: center;
	}
	.lb-flex{
		width: 100%;
		margin-bottom: 0px;
	}
	.green{
		color: #28a745;
	}
	.red{
		color: #dc3545;
	}
	.card-products{
		min-height: 810px;
	}
</style>
<div class="row">
    <div class="col-sm-8">
        <div class="card card-products">
        	<div class="card-header">
                <i class="fa fa-cutlery"></i><strong class="card-title pl-2">Productos</strong>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                	@php $cont = 0; @endphp
                	@foreach ($categorias as $item)
                		<li class="nav-item">
	                        <a class="nav-link {{ $cont == 0 ? "active" : "" }}" 
	                           id="nav-category-{{ $item->id_categoria }}-tab" 
	                           data-toggle="pill" 
	                           href="#nav-category-{{ $item->id_categoria }}" 
	                           role="tab" 
	                           aria-controls="nav-category-{{ $item->id_categoria }}" 
	                           aria-selected="true">{{ $item->nombre }}</a>
	                    </li>
	                    @php $cont++; @endphp
                	@endforeach
                </ul>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                	@php $cont = 0; @endphp
                	@foreach ($categorias as $item)
                		<div class="tab-pane fade {{ $cont == 0 ? "show active" : "" }}" 
                			 id="nav-category-{{ $item->id_categoria }}" 
                			 role="tabpanel" 
                			 aria-labelledby="nav-category-{{ $item->id_categoria }}-tab">
                			 @if (count($item->productos()) > 0)
                			 	@foreach ($item->productos() as $producto)
                        	 	
                        	 	@endforeach
                			 @else
                			 <center>
                			 	<img width="350" height="350" src="{{ asset('plantilla/images/empty_product.svg') }}">
                			 	<h3>No hay productos en esta categoria</h3>
                			 </center>
                			 @endif
                     	</div>
	                    @php $cont++; @endphp
                	@endforeach
                </div>
            </div>
        </div>        
    </div>

    <div class="col-sm-4">
    	<div class="card">
            <div class="card-header">
                <i class="fa fa-shopping-basket"></i><strong class="card-title pl-2">Factura de venta</strong>
            </div>
            <div class="card-body">
                <div class="mx-auto d-block">
                    <img id="cliente-imagen" class="rounded-circle mx-auto d-block" 
                    	 width="90"
                    	 height="90" 
                    	 src="{{ asset('plantilla/images/app/user.jpg') }}" 
                    	 alt="Imagen del usuario">
                    <h5 class="text-sm-center mt-2 mb-1" id="cliente-nombre">
                    	Cliente <a style="cursor: pointer;" onclick="ModalCliente()"><i class="fa fa-edit"></i></a>
                    </h5>
                    <div class="location text-sm-center"><i class="fa fa-map-marker"></i> {{ $licencia->ciudad }}</div>
                </div>
                <hr>
                <strong class="card-title">Productos adquiridos</strong>
                <br>
                <div class="table-stats order-table ov-h mt-2">
                    <table class="table" id="detalles">
                        <thead>
                            <tr>
                                <th><center><b>Producto</b></center></th>
                                <th><center><b>Cantidad</b></center></th>
                                <th><center><b>Total</b></center></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                        		<td colspan="3"><center><i>No hay productos seleccionados</i></center></td>
                        	</tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="form-group d-flex">
                	<label class="lb-flex">Subtotal</label>
                	<input type="text" id="factura-subtotal" disabled placeholder="0" class="form-control">
                </div>
                <div class="form-group d-flex">
                	<label class="lb-flex"><span class="green"><b>+</b></span> Servicio Voluntario ($)</label>
                	<input type="text" id="factura-servicio-voluntario" placeholder="0" class="form-control">
                </div>
                <div class="form-group d-flex">
                	<label class="lb-flex"><span class="red"><b>-</b></span> Descuento ($)</label>
                	<input type="text" id="factura-descuento" placeholder="0" class="form-control">
                </div>
                <div class="form-group d-flex">
                	<label class="lb-flex"><b>Total</b></label>
                	<input type="text" id="factura-total" disabled placeholder="0" class="form-control">
                </div>
                <div class="form-group">
                	<label>Observaciones</label>
                	<textarea id="factura-observaciones" class="form-control" rows="3"></textarea>
                </div>
                <hr>
                <div class="card-text text-sm-center">
                    <a href="#"><i class="fa fa-facebook pr-1"></i></a>
                    <a href="#"><i class="fa fa-twitter pr-1"></i></a>
                    <a href="#"><i class="fa fa-linkedin pr-1"></i></a>
                    <a href="#"><i class="fa fa-pinterest pr-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE EDICION DE INFO DE CLIENTE -->
    <div class="modal fade" id="modal-cliente" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Información del cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    	<label>Nombre del cliente</label>
                    	<input type="text" id="modal-cliente-nombre" class="form-control">
                    </div>
                    <div class="form-group">
                    	<label>Telefono del cliente</label>
                    	<input type="text" id="modal-cliente-telefono" class="form-control">
                    </div>
                    <div class="form-group">
                    	<label>Identificación del cliente</label>
                    	<input type="text" id="modal-cliente-identificacion" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="GuardarInfoCliente()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(()=>{
		 $('.nav-pills').scrollingTabs()
		 $('body').addClass("open")
	})
	var factura = {
		cliente: {
			nombre: null,
			telefono: null,
			identificacion: null 
		},
		servicioVoluntario: 0,
		detalles : []
	}
	function ModalCliente() {
		$("#modal-cliente").modal("show")
	}

	function GuardarInfoCliente() {
		$("#modal-cliente").modal("hide")
		if ($("#modal-cliente-nombre").val().trim() != "") 
			this.factura.cliente.nombre = $("#modal-cliente-nombre").val()

		if ($("#modal-cliente-telefono").val().trim() != "") 
			this.factura.cliente.telefono = $("#modal-cliente-telefono").val()

		if ($("#modal-cliente-identificacion").val().trim() != "") 
			this.factura.cliente.identificacion = $("#modal-cliente-identificacion").val()

		this.ActualizarVistaPedido()
	}

	function ActualizarVistaPedido() {
		$("#cliente-nombre").html(this.factura.cliente.nombre == null ? "Cliente" : this.factura.cliente.nombre)
	}
</script>
<script src="{{ asset('scroll-tabs/jquery.scrolling-tabs.js') }}"></script>
<script src="{{ asset('scroll-tabs/st-demo.js') }}"></script>
@endsection

