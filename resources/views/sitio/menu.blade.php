<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
  	<title>{{ $licencia->nombre }}</title>
	<link rel="apple-touch-icon" href="{{ $licencia->get_imagen() }}">
    <link rel="shortcut icon" href="{{ $licencia->get_imagen() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Menu">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <link rel="stylesheet" href="{{ asset('plantilla_menu/nicepage.css') }}" media="screen">
	<link rel="stylesheet" href="{{ asset('plantilla_menu/Menu.css') }}" media="screen">
    <script class="u-script" type="text/javascript" src="{{ asset('plantilla_menu/jquery.js') }}" defer=""></script>
    <script class="u-script" type="text/javascript" src="{{ asset('nicepage.js') }}" defer=""></script>
    <meta name="generator" content="Nicepage 3.24.3, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700">
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Menu">
    <meta property="og:type" content="website">
    <style>
    	.u-section-1 .u-list-1 {
		    margin-top: 20px !important;
		}
		.u-section-1 .u-text-1 {
		    margin: 1px auto 0;
		}
    </style>
  </head>
  <body class="u-body">
    <section class="u-align-center u-clearfix u-grey-10 u-section-1" id="carousel_0c4f">
      <div class="u-clearfix u-sheet u-sheet-1">
      	<img width="100" src="{{ $licencia->get_imagen() }}" style="margin-top: 20px;">
        <h1 class="u-custom-font u-font-oswald u-text u-text-default u-text-palette-3-base u-text-1">Menu</h1>
        <div class="u-expanded-width-xs u-list u-list-1">
          <div class="u-repeater u-repeater-1">
          	@foreach ($productos as $item)
          		<div class="u-container-style u-list-item u-repeater-item u-white u-list-item-1">
	              <div class="u-container-layout u-similar-container u-valign-bottom u-container-layout-1">
	                <img alt="" class="u-expanded-width-xs u-image u-image-default u-image-1" src="{{ $item->get_imagen() }}">
	                <div class="u-container-style u-expanded-width-xs u-group u-video-cover u-group-1">
	                  <div class="u-container-layout u-valign-middle-xs u-container-layout-2">
	                    <h3 class="u-custom-font u-font-oswald u-text u-text-2">{{ $item->nombre }}</h3>
	                    <p class="u-text u-text-3">{{ $item->descripcion }}</p>
	                    <br>
	                    <h6 class="u-text u-text-palette-3-base u-text-4" style="bottom: 0px;position: absolute;">${{ number_format($item->precio_venta,0,'.','.') }}</h6>
	                    <!--
	                    <a href="https://nicepage.com/joomla-page-builder" class="u-btn u-btn-rectangle u-button-style u-grey-10 u-btn-1">VER MAS<br>
	                    </a>
	                	-->
	                  </div>
	                </div>
	              </div>
	            </div>
          	@endforeach       
          </div>
        </div>
      </div>
    </section>


    <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-b881"><div class="u-clearfix u-sheet u-sheet-1">
    	<label></label>
        <p class="u-small-text u-text u-text-variant u-text-1">
        	<b>{{ $licencia->nombre }}</b><br>
        	Desarrollado por Zorax
        </p>
      </div>
  	</footer>
  </body>
</html>
