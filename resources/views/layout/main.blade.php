@php
 $usuario = \App\Usuario::find(session('id_usuario'));
 $licencia = $usuario->tercero->licencia;
@endphp

<!doctype html>
<html class="no-js" lang="es"> 


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Zorax - Sistema de facturacion</title>
    <meta name="description" content="Zorax - Sistema de facturacion">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('plantilla/images/app/zorax_small.png') }}">
    <link rel="shortcut icon" href="{{ asset('plantilla/images/app/zorax_small.png') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{ asset('plantilla/assets/js/main.js') }}"></script>

    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
    <script src="{{ asset('plantilla/assets/js/init/weather-init.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="{{ asset('plantilla/assets/js/init/fullcalendar-init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('plantilla/assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('plantilla/assets/css/style.css') }}">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('plantilla/assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('plantilla/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('plantilla/assets/css/lib/chosen/chosen.min.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
    <script src="{{ asset('TableToExcel.js') }}"></script>


   <style>
        .content {
            float: left;
            padding: 1.875em;
            width: 100%; 
            min-height: 800px !important;
        }
        .red-icon{
            color: #af1417 !important;
            cursor: pointer;
        }
        #weatherWidget .currentDesc {
            color: #ffffff!important;
        }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
        .media{
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }
        .chosen-container-multi .chosen-choices {
            padding: .3rem .75rem;
            border-radius: .25rem;
        }
        .pointer{
            cursor: pointer;
        }
        .pointer:hover{
            -webkit-transform: scale(1.05);
            -ms-transform: scale(1.05);
            transform: scale(1.05);
            transition-duration: 0.5s;
        }

    </style>
    <script>
    $(document).ready(function () {
        $('#filtro').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('#bodytable tr').hide();
            $('#bodytable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        })
    });
    </script>
    <script>
        function buscar(caracteres) {
            console.log(caracteres)
            if (caracteres.length > 3) {
                url = "/tercero/buscar/"+caracteres
                $.get(url, (response) =>{
                    var resultados = ""
                    if(response.length > 0){
                        response.forEach((tercero)=>{
                            resultados += "<a class='dropdown-item media' href='/tercero/view/"+tercero.id_tercero+"'><b>"+tercero.identificacion+" - "+tercero.nombres+" "+tercero.apellidos+"</b></a>"
                        })
                        if (resultados != "") {
                            $("#div_busqueda").html(resultados)
                            $("#div_busqueda").fadeIn()
                        }else{
                            $("#div_busqueda").html("")
                            $("#div_busqueda").fadeOut()
                        }
                    }else{
                        $("#div_busqueda").html("")
                        $("#div_busqueda").fadeOut()
                    }
                })
            }
            else{
                $("#div_busqueda").html("")
                $("#div_busqueda").fadeOut()
            }
        }
    </script>

    <style type="text/css">
        .fab-container{
            position: fixed;
            top: 70px;
            right: 50px;
            z-index: 999;
            cursor: pointer;
        }

        .fab-icon-holder{
            width: 50px;
            height: 50px;
            border-radius: 100%;
            background: #016fb9;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        .fab-icon-holder:hover{
            opacity: 0.8;

        }
        .fab-icon-holder i{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-style: 25px;
            color: #ffffff;
            font-size: 22px;
        }

        .fab{
            width: 60px;
            height: 60px;
            background: #d23f31;
        }

        .fab-options{
            list-style-type: none;
            margin: 0;
            position: absolute;
            top: 80px;
            right: 0;
            opacity: 0;
            transition: all 0.3s ease;
            transform: scale(0);
            transform-origin: 85% top;
        }

        .fab:hover + .fab-options, .fab-options:hover{
            opacity: 1;
            transform: scale(1);
        }
        .fab:hover + .right-panel{
            background: #000000 !important;
        }

        .fab-options li{
            display: flex;
            justify-content: flex-end;
            padding: 5px;
        }

        .fab-label{
            padding: 2px 5px;
            align-self: center;
            user-select: none;
            white-space: nowrap;
            border-radius: 3px;
            font-size: 16px;
            background: #666666;
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            margin-right: 10px;
        }

        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #23558a;
        }
    </style>
</head>

<body onclick="$('#div_busqueda').fadeOut()">


    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                @php
                \App\Menu::loadMenu();
                @endphp
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    @yield('menu','')
    
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    
                    <a class="navbar-brand" style="text-align: center; margin-right: 0px;" href=""><img height="40" width="auto" src="{{ $licencia->get_imagen() }}" alt="{{ $licencia->nombre }}"></a>
                    <a class="navbar-brand hidden" href="" ><img src="{{ $licencia->get_imagen_small() }}" alt="{{ $licencia->nombre }}"></a>
                    <a id="menuToggle" class="menutoggle" style="width: 0px;"><i class="fa fa-bars"></i></a>
                    
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="search-trigger" onclick="$('#caracteres').focus()"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input id="caracteres" class="form-control mr-sm-2" type="text" placeholder="Buscar tercero..." onkeyup="buscar(this.value)" aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                                 <div class="dropdown-menu div_busqueda" id="div_busqueda">
                                </div>
                            </form>
                            
                        </div>

                        <div class="dropdown for-notification">
                            <button class="btn dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                               <!-- <span class="count bg-danger">3</span> -->
                            </button>
                            <div class="dropdown-menu" aria-labelledby="notification">
                                <p class="red">No tienes notificaciones</p>
                                <!--
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-check"></i>
                                    <p></p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-info"></i>
                                    <p></p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-warning"></i>
                                    <p></p>
                                </a>
                                -->
                            </div>
                        </div>
                        <div class="dropdown for-notification">
                            <a class="btn btn-secondary dropdown-toggle" href="{{ route('factura/facturador') }}" alt="Facturar">
                                <i class="fa fa-plus-square"></i>
                               <!-- <span class="count bg-danger">3</span> -->
                            </a>
                        </div>

                        <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="caja" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-money"></i> <b>Abrir caja</b>                               
                            </button>
                        </div>

                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" height="40" width="46" src="{{ $usuario->tercero->get_imagen() }}" alt="{{ $usuario->tercero->nombre_completo() }}">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i>Configuracion de cuenta</a>

                            <a class="nav-link" href="{{ route('logout') }}"><i class="fa fa-power -off"></i>Cerrar sesion</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                 @yield('content','')
            <!-- /#add-category -->
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Zorax - Sistema de facturación 
                    </div>
                    <div class="col-sm-6 text-right">
                        Designed by <a href="ldaponte98@gmail.com">Luis Daniel Aponte Daza</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
     <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('plantilla/assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>

    <script>
        jQuery(document).ready(function() {
            jQuery(".standardSelect").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
    </script>
    
</body>
</html>
