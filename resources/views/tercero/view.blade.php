@extends('layout.main')
@section('menu')
    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fa fa-bars"></i>
        </div>
        <ul class="fab-options">
            <li onclick="location.href='/factura/crear?tipo=16&id_tercero={{ $tercero->id_tercero }}'">
                <span class="fab-label">Facturar</span>
                <div class="fab-icon-holder">
                    <i class="ti-money"></i>
                </div>
            </li>
            <li onclick="location.href='/factura/crear?tipo=17&id_tercero={{ $tercero->id_tercero }}'">
                <span class="fab-label">Cotizar</span>
                <div class="fab-icon-holder">
                    <i class="ti-shopping-cart"></i>
                </div>
            </li>
            <li onclick="location.href='/tercero/editar/{{ $tercero->id_tercero }}'">
                <span class="fab-label">Modificar</span>
                <div class="fab-icon-holder">
                    <i class="ti-pencil"></i>
                </div>
            </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <!-- Credit Card -->
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <h4><b>Datos personales</b></h4><br>
                                        <center>
                                            <img src="@if ($tercero->imagen == null or $tercero->imagen == '') {{ asset('plantilla/images/app/user.jpg') }} @else {{ asset('imagenes/tercero/' . $tercero->imagen) }} @endif"
                                                id="img_imagen" alt="image" class="rounded-circle" width="150"
                                                height="150">
                                            <br>
                                            <strong
                                                class="card-title span_tipo"><b>{{ $tercero->tipo->nombre }}</b></strong>
                                        </center>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Nombres:
                                                    </b>{{ $tercero->nombres }}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Apellidos:
                                                    </b>{{ $tercero->apellidos }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Tipo de
                                                        identificación:
                                                    </b>{{ $tercero->tipo_identificacion->nombre }}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Identificación:
                                                    </b>{{ $tercero->identificacion }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Correo electrónico:
                                                    </b>{{ $tercero->email }}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Genero:
                                                    </b>{{ $tercero->sexo->nombre }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Tipo tercero:
                                                    </b>{{ $tercero->tipo->nombre }}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label mb-1"><b>Estado:
                                                    </b>{{ $tercero->get_estado() }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Telefono:
                                                    </b>{{ $tercero->telefono }}</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1"><b>Dirección:
                                                    </b>{{ $tercero->direccion }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card text-white bg-flat-color-1">
                                        <div class="card-body">
                                            <div class="card-left pt-1 float-left">
                                                <h3 class="mb-0 fw-r">
                                                    <span class="currency float-left mr-1">$</span>
                                                    <span id="count-1" class="count">{{ $tercero->get_total_deuda() }}</span>
                                                </h3>
                                                <p class="text-light mt-1 m-0">Deuda</p>
                                            </div>

                                            <div class="card-right float-right text-right">
                                                <i class="icon fade-5 icon-lg pe-7s-cart"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card text-white bg-flat-color-3">
                                        <div class="card-body">
                                            <div class="card-left pt-1 float-left">
                                                <h3 class="mb-0 fw-r">
                                                    <span class="currency float-left mr-1">$</span>
                                                    <span id="count-2" class="count">{{ $tercero->get_total_ahorro() }}</span>
                                                </h3>
                                                <p class="text-light mt-1 m-0">Ahorro</p>
                                            </div>
                                            <div class="card-right float-right text-right">
                                                <i class="icon fade-5 icon-lg pe-7s-portfolio"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card text-white bg-flat-color-4">
                                        <div class="card-body">
                                            <div class="card-left pt-1 float-left">
                                                <h3 class="mb-0 fw-r">
                                                    <span class="currency float-left mr-1">$</span>
                                                    <span id="count-3" class="count">{{ $tercero->get_total_se_le_debe() }}</span>
                                                </h3>
                                                <p class="text-light mt-1 m-0">Se le debe</p>
                                            </div>
                                            <div class="card-right float-right text-right">
                                                <i class="icon fade-5 icon-lg pe-7s-cash"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="custom-tab">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab"
                                            href="#nav-home" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Facturas de venta</a>
                                        <a class="nav-item nav-link" id="nav-creditos-tab" data-toggle="tab"
                                            href="#nav-creditos" role="tab" aria-controls="nav-creditos"
                                            aria-selected="false">Creditos por pagar</a>
                                        <a class="nav-item nav-link" id="nav-ahorros-tab" data-toggle="tab"
                                            href="#nav-ahorros" role="tab" aria-controls="nav-ahorros"
                                            aria-selected="false">Ahorros</a>
                                        <a class="nav-item nav-link" id="nav-creditos-deber-tab" data-toggle="tab"
                                            href="#nav-creditos-deber" role="tab" aria-controls="nav-creditos-deber"
                                            aria-selected="false">Creditos a deber</a>    
                                        <a class="nav-item nav-link" id="nav-cotizaciones-tab" data-toggle="tab"
                                            href="#nav-cotizaciones" role="tab" aria-controls="nav-cotizaciones"
                                            aria-selected="false">Cotizaciones</a>
                                    </div>
                                </nav>
                                @php
                                    $facturas = $tercero->facturas;
                                @endphp
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        {{ view('tercero.lista_facturas', compact('tercero', ['facturas'])) }}
                                    </div>

                                    <div class="tab-pane fade" id="nav-creditos" role="tabpanel"
                                        aria-labelledby="nav-creditos-tab">
                                        {{ view('tercero.lista_creditos', compact('tercero', ['facturas'])) }}
                                    </div>

                                    <div class="tab-pane fade" id="nav-ahorros" role="tabpanel"
                                        aria-labelledby="nav-ahorros-tab">
                                        {{ view('tercero.lista_ahorros', compact('tercero', ['facturas'])) }}
                                    </div>

                                    <div class="tab-pane fade" id="nav-creditos-deber" role="tabpanel"
                                        aria-labelledby="nav-creditos-deber-tab">
                                        {{ view('tercero.lista_creditos_deber', compact('tercero', ['facturas'])) }}
                                    </div>

                                    <div class="tab-pane fade" id="nav-cotizaciones" role="tabpanel"
                                        aria-labelledby="nav-cotizaciones-tab">
                                        {{ view('tercero.lista_cotizaciones', compact('tercero', ['facturas'])) }}
                                    </div>
                                </div>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            $(".count").each(function(index) {
                let id = $(this)[0].id
                let value = $(this)[0].innerHTML
                $("#" + id).html(setPuntosNumero(value))
            });
        }, 5 * 1000);

        function setPuntosNumero(strNumber) {
            let cont = 0;
            let result = ""
            for (let i = strNumber.length - 1; i >= 0; i--) {
                cont++
                result = strNumber[i] + result
                if(cont == 3 && i != 0){
                    result = "." + result
                    cont = 0
                } 
            }
            return result
        }
    </script>
@endsection
