@php
    $licencia = \App\Licencia::find(session('id_licencia'));
@endphp
@extends('layout.main')
@section('menu')
    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fa fa-bars"></i>
        </div>
        <ul class="fab-options">
            <li onclick="Guardar(0)" id="permiso-guardar">
                <span class="fab-label">Guardar</span>
                <div class="fab-icon-holder">
                    <i class="ti-save"></i>
                </div>
            </li>
            <li onclick="Guardar(1)" id="permiso-guardar-finalizar">
                <span class="fab-label">Guardar y finalizar</span>
                <div class="fab-icon-holder">
                    <i class="ti-shopping-cart"></i>
                </div>
            </li>
            <li onclick="Imprimir()" id="permiso-imprimir">
                <span class="fab-label">Imprimir</span>
                <div class="fab-icon-holder">
                    <i class="ti-printer"></i>
                </div>
            </li>
        </ul>
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
    .hide{
        display: none !important;
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
    .box-quantity{
        box-shadow: 0 0 20px rgb(0 0 0 / 8%);
        border: 0;
        padding: 10px;
        border-radius: 5px;
    }
    .search{
        padding: .75rem .95rem;
        height: auto;
        border: none;
        border-radius: 30px;
        box-shadow: 0 0 20px rgb(0 0 0 / 8%);
    }
    .dropdown-search{
        width: 100%;
        box-shadow: 0 0 20px rgb(0 0 0 / 8%);
        border-radius: 5px;
    }
    .btn-erase{
        background: transparent;
        margin-bottom: 7px;
    }
    .chosen-container{
        width: 107% !important;
    }
</style>
<div class="row">
    <div class="col-sm-8">
        <div class="d-flex">
            <input type="text" placeholder="Consulta productos aqui..." onkeyup="BuscarProductos(this.value)" class="form-control search mb-2" id="filtro-productos">
            <button class="btn btn-secundary btn-erase" onclick="$('#filtro-productos').val(''); BuscarProductos('')"><i class="fa fa-times"></i></button>
        </div>
        
        <div class="dropdown for-notification">
            <div class="dropdown-menu dropdown-search" aria-labelledby="notification" id="div-busqueda-productos"></div>
        </div>
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
                             <div class="row">
                			 @if (count($item->productos()) > 0)
                			 	@foreach ($item->productos() as $producto)
                                <div class="col-sm-3">
                                    <div class="card pointer" onclick="AgregarProducto({{ $producto->id_producto }})">
                                        <div class="card-body">
                                            <div class="mx-auto d-block">
                                                <img width="100" height="100" class="rounded-circle mx-auto d-block" src="{{ $producto->get_imagen() }}" alt="Producto">
                                                <h5 class="text-sm-center mt-2 mb-1">{{ $producto->nombre }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        	 	@endforeach
                			 @else
                             <div class="col-sm-12">
                                 <center>
                                    <img width="350" height="350" src="{{ asset('plantilla/images/empty_product.svg') }}">
                                    <h3>No hay productos en esta categoria</h3>
                                 </center>
                             </div> 
                			 @endif
                             </div>
                     	</div>
	                    @php $cont++; @endphp
                	@endforeach
                </div>
            </div>
        </div>        
    </div>

    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <select id="select-canal" onchange="ValidarCanal(this.value)" data-placeholder="Selecciona un canal" class="form-control select2">
                        <option value="" label="default"></option>
                        @php
                            $items = \App\Dominio::all()->where('id_padre', 44);
                        @endphp
                        @foreach($items as $item)
                            <option value="{{ $item->id_dominio }}">{{ strtoupper($item->nombre) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6" id="div-mesas" style="display: none;">
                <div class="form-group">
                    <select id="select-mesa" onchange="AsignarMesa(this.value)" data-placeholder="Seleccione la mesa" class="form-control select2">
                        <option value="" label="default"></option>
                        @foreach($mesas as $item)
                            <option value="{{ $item->id_mesa }}">{{ strtoupper($item->numero) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
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
                    <h5 class="text-sm-center mt-2 mb-1" ><b id="cliente-nombre">Cliente</b> <a style="cursor: pointer;" onclick="ModalCliente()"><i class="fa fa-edit"></i></a>
                    </h5>
                    <div class="location text-sm-center"><i class="fa fa-map-marker"></i> {{ $licencia->ciudad }}</div>
                </div>
                <hr>
                <strong class="card-title">Productos adquiridos</strong>
                <br>
                <div class="table-stats order-table ov-h mt-2">
                    <table class="table" id="table-detalles">
                        <thead>
                            <tr>
                                <th><center><b>Producto</b></center></th>
                                <th><center><b>Cantidad</b></center></th>
                                <th><center><b>Total</b></center></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                        		<td colspan="4"><center><i>No hay productos seleccionados</i></center></td>
                        	</tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="form-group d-flex">
                    <label class="lb-flex">Formas de pago</label>
                    <select id="factura-formas-pago" data-placeholder="Escoje una o mas..." multiple class="standardSelect form-control">
                        <option value="" label="default"></option>
                        @foreach($formas_pago as $item)
                            <option @if(in_array($item->id_dominio, $formas_pago_selected)) selected @endif 
                                value="{{ $item->id_dominio }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group d-flex">
                	<label class="lb-flex">Subtotal</label>
                	<input type="text" id="factura-subtotal" disabled placeholder="0" class="form-control">
                </div>
                <div class="form-group d-flex hide" id="div-domicilio">
                    <label class="lb-flex"><span class="green"><b>+</b></span> Domicilio ($)</label>
                    <input onkeyup="ValidarDescuentoServicio()" type="number" id="factura-domicilio" placeholder="0" class="form-control">
                </div>
                <div class="form-group d-flex">
                	<label class="lb-flex"><span class="green"><b>+</b></span> Servicio Voluntario ($)</label>
                	<input onkeyup="ValidarDescuentoServicio()" type="number" id="factura-servicio-voluntario" placeholder="0" class="form-control">
                </div>
                <div class="form-group d-flex">
                	<label class="lb-flex"><span class="red"><b>-</b></span> Descuento ($)</label>
                	<input onkeyup="ValidarDescuentoServicio()" type="number" id="factura-descuento" placeholder="0" class="form-control">
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
@csrf
<script>
	$(document).ready(()=>{
		 $('.nav-pills').scrollingTabs()
		 $('body').addClass("open")
         LlenarProductos()
         ValidarPermisosFactura()
         //$("#div-busqueda-productos").fadeIn()
	})

    var productos = []
	var factura = {
        id_factura: null,
		cliente: {
			nombre: null,
			telefono: null,
			identificacion: null 
		},
        id_dominio_canal : null,
        id_mesa : null,
        domicilio : 0,
        observaciones : "",
        detalles : [],
        formas_pago : null,
        servicio_voluntario: 0,
        descuentos: 0,
        total: 0,
        finalizada : 0		
	}

    function LlenarProductos() {
        @foreach ($productos as $producto)
            this.productos.push({
                'id_producto' : {{ $producto->id_producto }},
                'nombre' : '{{ $producto->nombre }}',
                'precio_venta' : {{ $producto->precio_venta }},
                'presentacion' : '{{ $producto->presentacion->nombre }}',
                'imagen' : '{{ $producto->get_imagen() }}',
                'cantidad_actual' : '{{ $producto->cantidad_actual }}',
                'tipo' : '{{ $producto->id_dominio_tipo_producto }}',
                'categorias' : JSON.parse('{{ json_encode($producto->get_id_categorias()) }}')
            });
        @endforeach
        console.log(this.productos)
    }

    function AgregarProducto(id_producto) {
        let producto = this.productos.find(item => item.id_producto == id_producto)
        let busqueda = this.factura.detalles.find(item => item.id_producto == id_producto)
        if (busqueda) {
            busqueda.cantidad += 1;
            let pos = 0;
            this.factura.detalles.forEach((item) => {
                if (item.id_producto == busqueda.id_producto) this.factura.detalles.splice(pos, 1, busqueda)
                pos++
            })
        }else{
            this.factura.detalles.push({
                'id_producto' : producto.id_producto,
                'nombre' : producto.nombre,
                'precio_venta' : producto.precio_venta,
                'presentacion' : producto.presentacion,
                'cantidad' : 1
            })
        }
        this.ActualizarVistaPedido()
    }

    function EliminarProducto(id_producto) {
        let resp = confirm("¿Seguro que desea eliminar este producto de la compra?")
        if (resp) {
            let pos = 0;
            this.factura.detalles.forEach((item) => {
                if (item.id_producto == id_producto) this.factura.detalles.splice(pos, 1)
                pos++
            })
            this.ActualizarVistaPedido()
        }
    }

    function ValidarDescuentoServicio() {
        let descuento = $("#factura-descuento").val()
        let servicio  = $("#factura-servicio-voluntario").val()
        let domicilio  = $("#factura-domicilio").val()
        this.factura.descuentos = 0
        this.factura.servicio_voluntario = 0
        this.factura.domicilio = 0
        if ($.isNumeric(descuento))this.factura.descuentos = parseFloat(descuento)
        if ($.isNumeric(servicio)) this.factura.servicio_voluntario = parseFloat(servicio)
        if ($.isNumeric(domicilio)) this.factura.domicilio = parseFloat(domicilio)
            this.ActualizarVistaPedido()
    }

	function ModalCliente() {
		$("#modal-cliente").modal("show")
        if (this.factura.cliente.nombre) $("#modal-cliente-nombre").val(this.factura.cliente.nombre)
        if (this.factura.cliente.telefono) $("#modal-cliente-telefono").val(this.factura.cliente.telefono)
        if (this.factura.cliente.identificacion) $("#modal-cliente-identificacion").val(this.factura.cliente.identificacion)
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
        let tabla = ""
        let sub_total = 0
        if (this.factura.detalles.length == 0) {
            tabla = `<tr>
                        <td colspan="4"><center><i>No hay productos seleccionados</i></center></td>
                    </tr>`
        }else{
            this.factura.detalles.forEach((item) => {
                let valor_producto = item.cantidad * item.precio_venta;
                tabla += `<tr>
                            <td><center>${item.nombre}</center></td>
                            <td><center>
                            <div class="dropdown for-notification">
                                <button class="btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
                                    ${item.cantidad} ${item.presentacion}
                                </button>
                                <div class="dropdown-menu box-quantity">
                                    <div class="input-group dropdowncontent" >
                                        <input type="text" id="cantidad-item-${item.id_producto}" value="${item.cantidad}" class="form-control">
                                        <div class="input-group-btn"><span onclick="EstablecerCantidad(${item.id_producto})" class="btn btn-success"><i class="fa fa-check"></i></span></div>
                                    </div>  
                                </div>
                            </div>
                            </center></td>
                            <td><center>$${format(valor_producto)}</center></td>
                            <td>
                                <span onclick='EliminarProducto(${item.id_producto})'>
                                    <i class='fa fa-times-circle red-icon'></i>
                                </span>
                            </td>
                        </tr>`
                sub_total += valor_producto
            })
        }
        $("#table-detalles tbody").html(tabla)

        //ACTUALIZAMOS CAMPOS DE TOTALES
        let total = 0
        $("#factura-subtotal").val("$" + format(sub_total))
        total += sub_total
        let servicio = $("#factura-servicio-voluntario").val()
        if ($.isNumeric(servicio)) total += parseFloat(servicio)
        let descuentos = $("#factura-descuento").val()
        if ($.isNumeric(descuentos)) total -= parseFloat(descuentos)

        let domicilio = $("#factura-domicilio").val()
        if ($.isNumeric(domicilio) && this.factura.id_dominio_canal == {{ App\Dominio::get('Domicilio') }}) total += parseFloat(domicilio)
        $("#factura-total").val("$" + format(total))
        this.factura.total = parseFloat(total)
	}

    function EstablecerCantidad(id_producto) {
        let cantidad = $(`#cantidad-item-${id_producto}`).val()
        if ($.isNumeric(cantidad)){
            let busqueda = this.factura.detalles.find(item => item.id_producto == id_producto)
            if (busqueda) {
                busqueda.cantidad = parseFloat(cantidad);
                let pos = 0;
                this.factura.detalles.forEach((item) => {
                    if (item.id_producto == busqueda.id_producto) this.factura.detalles.splice(pos, 1, busqueda)
                    pos++
                })
                this.ActualizarVistaPedido()
            }
        } 
    }

    function BuscarProductos(caracteres) {
        if (caracteres.trim() != "" && caracteres.length >= 3) {
            let filtros = this.productos.filter(item => item.nombre.toUpperCase().includes(caracteres.toUpperCase()) && item.tipo == 36)
            var resultados = ""
            if(filtros.length > 0){
                let cont = 0
                filtros.forEach((item)=>{
                    if (cont != 0) resultados += `<hr class="mb-1 mt-1">`
                    resultados += `
                        <div class="dropdown-item media pointer-low" onclick="AgregarProducto(${item.id_producto})">
                            <img class="rounded-circle mr-2" src="${item.imagen}" width="45" height="45" >
                            <div class="content-dropdown">
                                <label class="mb-0">${item.nombre.toUpperCase()}</label><br>
                                <b>$${format(item.precio_venta)}</b>
                            </div>
                        </div>`
                    cont++
                })
                if (resultados != "") {
                    $("#div-busqueda-productos").html(resultados)
                    $("#div-busqueda-productos").fadeIn()
                }else{
                    $("#div-busqueda-productos").html("")
                    $("#div-busqueda-productos").fadeOut()
                }
            }else{
                $("#div-busqueda-productos").html("")
                $("#div-busqueda-productos").fadeOut()
            }
        }else{
            $("#div-busqueda-productos").html("")
            $("#div-busqueda-productos").fadeOut()
        }
    }

    function ValidarCanal(id_dominio_canal) {
        this.factura.id_dominio_canal = id_dominio_canal

        $("#factura-domicilio").val("")
        if (id_dominio_canal == {{ App\Dominio::get('Mesa') }}) {
            $("#div-mesas").fadeIn()
            $("#div-domicilio").addClass('hide')
            this.factura.domicilio = 0
        }

        if (id_dominio_canal == {{ App\Dominio::get('Domicilio') }}) {
            $("#div-mesas").fadeOut()
            $("#div-domicilio").removeClass('hide')
        }

        if (id_dominio_canal == {{ App\Dominio::get('No definido') }}) {
            $("#div-mesas").fadeOut()
            $("#div-domicilio").addClass('hide')
            this.factura.domicilio = 0
        }
        this.ActualizarVistaPedido()
    }

    function AsignarMesa(id_mesa) {
        this.factura.id_mesa = id_mesa;
    }

    function ValidarPermisosFactura() {
        if (this.factura.finalizada == 1) {
            $("#permiso-guardar").fadeOut()
            $("#permiso-guardar-finalizar").fadeOut()
            $("#permiso-imprimir").fadeIn()
        }

        if (this.factura.finalizada == 0) {
            $("#permiso-guardar").fadeIn()
            $("#permiso-guardar-finalizar").fadeIn()

            if (this.factura.id_factura != null) {
                $("#permiso-imprimir").fadeIn()
            }else{
                $("#permiso-imprimir").fadeOut()
            }
        }
    }

    function Guardar(finalizada) {
        this.factura.finalizada = finalizada
        this.factura.observaciones = $("#factura-observaciones").val()
        this.factura.formas_pago = $("#factura-formas-pago").val()

        if (this.factura.detalles.length == 0) {
            toastr.error("Es necesario escoger por lo menos un producto para el pedido", "Error")
            return;
        }

        if (this.factura.formas_pago == null) {
            toastr.error("Es necesario escoger por lo menos una forma de pago para el pedido", "Error")
            return;
        }

        if (this.factura.id_dominio_canal == null) {
            toastr.error("Es necesario escoger el canal de venta para el pedido", "Error")
            return;
        }

        if (this.factura.id_dominio_canal == {{ App\Dominio::get('Mesa') }} && this.factura.id_mesa == null) {
            toastr.error("Es necesario escoger el numero de mesa para el pedido", "Error")
            return;
        }

        Loading(true, "Guardando factura...")

        let url = "{{ route('factura/finalizar_factura_facturador') }}"
        var _token = ""
        $("[name='_token']").each(function() { _token = this.value })
        let request = {
            '_token' : _token,
            'factura' : this.factura
        }
        $.post(url, request, (response) => {
            Loading(false)
            if (!response.error) {
                this.factura.id_factura = response.id_factura
                toastr.success(response.mensaje, "Proceso exitoso")
                this.ValidarPermisosFactura()
            }else{
                toastr.error(response.mensaje, "Error")
            }
            console.log(response)
        })
        .fail((error) => {
            Loading(false)
            console.log(error)
            toastr.error("Ha ocurrido un error, por favor intentelo nuevamente", "Error")
        })
        console.log("bien")
    }

    function Imprimir() {
        // body...
    }
    
    
</script>
<script src="{{ asset('scroll-tabs/jquery.scrolling-tabs.js') }}"></script>
<script src="{{ asset('scroll-tabs/st-demo.js') }}"></script>
@endsection

