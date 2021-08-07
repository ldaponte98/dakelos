@extends('layout.main')
@section('menu')
    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fa fa-bars"></i>
        </div>
        <ul class="fab-options">
            <li onclick="location.href = '/producto/crear'">
                <span class="fab-label"><b>Nuevo</b> producto / servicio / ingrediente</span>
                <div class="fab-icon-holder">
                    <i class="fa fa-laptop"></i>
                </div>
            </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Administrar productos / servicios / ingredientes</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::open(array('method' => 'post')) }}
                        <div class="row">
                            
                            <div class="col-sm-4">
                                
                            </div>
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-3" style="text-align: right !important;">
                                <input id="filtro" type="text" class="form-control" placeholder="Consulte aqui..." autocomplete="on">
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div><br><br>
                    <div class="col-lg-12">
                            <div class="card">
                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th class="serial"><center><i class="fa fa-laptop"></i></center></th>
                                                <th><center><b>Producto</b></center></th>
                                                <th><center><b>Descripción</b></center></th>
                                                <th><center><b>Precio venta</b></center></th>
                                                <th><center><b>Precio compra</b></center></th>
                                                <th><center><b>Iva</b></center></th>
                                                <th><center><b>Aplica inventario</b></center></th>
                                                <th><center><b>Estado</b></center></th>
                                                <th><center><b></b></center></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodytable">
                                            @php $cont = 1; @endphp
                                            @foreach($productos as $producto)
                                            <tr>
                                                <td><center><img class="rounded-circle" src="{{ $producto->get_imagen() }}" width="45" height="45" alt="tercero"></center></td>
                                                <td>{{ $producto->nombre }}</td>
                                                <td>{{ $producto->descripcion }}</td>
                                                <td>${{ number_format($producto->precio_venta,0,'\'','.') }}</td>
                                                <td>${{ number_format($producto->precio_compra,0,'\'','.') }}</td>
                                                <td>%{{ $producto->iva }}</td>
                                                <td>
                                                    <center>
                                                    @if($producto->descontado == 1)
                                                        Aplica
                                                    @else
                                                        No aplica
                                                    @endif
                                                    </center>
                                                </td>
                                                <td>{{ $producto->get_estado() }}</td>
                                                <td><a href="{{ route('producto/view', $producto->id_producto) }}">Ver</a></td>
                                                <td><a href="{{ route('producto/editar', $producto->id_producto) }}">Editar</a></td>
                                                
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


<script type="text/javascript">
        
</script>
@endsection