<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>
<body>
	
	<div class="mobile-app-container">
		<div class="app-inner-container" id="home" style="display:none">
			<div class="app-header">
				<h4>Hola,</h4>
				<h5>Vamos a explorar!</h5>
			</div>
			<div class="search-container">
				<i class="fas fa-search"></i>
				<input type="text" placeholder="Buscar lugares">
			</div>
			<div class="categories-container">
				<h4>Categorías</h4>
				<div class="category-collection" onclick="mostrar(3)">
					<div class="category-item">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/hotel.png">
						<h4>Hoteles</h4>
					</div>
					<div class="category-item" onclick="mostrar(3)">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/restaurant.png">
						<h4>Restaurantes</h4>
					</div>
					<div class="category-item" onclick="mostrar(3)">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/family.png">
						<h4>Actividades</h4>
					</div>
					<div class="category-item" onclick="mostrar(3)">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/travel-and-tourism-1.png">
						<h4>Experiencias</h4>
					</div>
				</div>
			</div>
			<div class="popular-container">
				<h4>Sitios por explorar</h4>
				<div class="name-collection">
					<h4>Todos</h4>
					<h4>Populares</h4>
					<h4>Recomendados</h4>
					<h4>Más visitados</h4>
				</div>
				<div class="popular-collection">
					<div class="single-popular" onclick="mostrar(4)">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/1-3.jpg">
						<h4>Playa blanca</h4>
						<h5>Valledupar</h5>
					</div>
					<div class="single-popular" onclick="mostrar(4)">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/1-2.jpg">
						<h4>Hotel El paso</h4>
						<h5>Valledupar</h5>
					</div>
					<div class="single-popular" onclick="mostrar(4)">
						<img src="https://info.vinapp.co/wp-content/uploads/2022/03/1-3.jpg">
						<h4>Playa blanca</h4>
						<h5>Valledupar</h5>
					</div>
				</div>
			</div>
		</div>

		
		<div class="inner-container-search" id="list" style="display: none;">
			<div class="search-container">
				<i class="fas fa-search"></i>
				<input type="text" placeholder="Buscar lugares">
			</div>
			<div class="filter-collection">
				<h4>Todos</h4>
				<h4>Populares</h4>
				<h4>Recomendados</h4>
				<h4>Más visitados</h4>
			</div>
			<div class="all-results">
				<div class="single-search-item" onclick="mostrar(5)">
					<img src="https://info.vinapp.co/wp-content/uploads/2022/03/3-5.jpg">
					<div class="stars">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
					</div>
					<div class="name-price">
						<h4>Playa blanca</h4>
						<h5>25.000</h5>
					</div>
					<div class="icons-collection">
						<h4><i class="fas fa-map-pin"></i> Santa marta</h4>
						<h4><i class="far fa-clock"></i> 8:00 a 2:00</h4>
					</div>
				</div>
				<div class="single-search-item" onclick="mostrar(5)">
					<img src="https://info.vinapp.co/wp-content/uploads/2022/03/3-5.jpg">
					<div class="stars">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
					</div>
					<div class="name-price">
						<h4>Playa blanca</h4>
						<h5>25.000</h5>
					</div>
					<div class="icons-collection">
						<h4><i class="fas fa-map-pin"></i> Santa marta</h4>
						<h4><i class="far fa-clock"></i> 8:00 a 2:00</h4>
					</div>
				</div>
				<div class="single-search-item" onclick="mostrar(5)">
					<img src="https://info.vinapp.co/wp-content/uploads/2022/03/3-5.jpg">
					<div class="stars">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
					</div>
					<div class="name-price">
						<h4>Playa blanca</h4>
						<h5>25.000</h5>
					</div>
					<div class="icons-collection">
						<h4><i class="fas fa-map-pin"></i> Santa marta</h4>
						<h4><i class="far fa-clock"></i> 8:00 a 2:00</h4>
					</div>
				</div>
			</div>		
		</div>

		
		<div class="inner-container-detail" id="detail" style="display: none;">
			<div class="image-detail">
				<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/files/img-3_f5666565-c070-4664-8562-b91db787caf3_360x.jpg?v=1534415048">
				<div class="back-button-container" onclick="mostrar(1)">
					<i class="fas fa-arrow-left"></i>
				</div>
			</div>	
			<div class="information-container">
				<div class="service-name">
					<h4>Birthdate cake</h4>
				</div>
				<div class="price">
					<h4>27.000</h4>
				</div>
				<div class="stars-detail">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<h4>4.9</h4>
				</div>
				<div class="description">
					<h4>About</h4>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi quos odio in, nisi, aspernatur ullam deserunt tempore atque, repellendus ducimus eligendi possimus vitae ad corporis nobis, omnis expedita architecto ut.</p>
				</div>
				<div class="option-button">
					<button  onclick="mostrar(4)">Comprar</button>
				</div>
			</div>
		</div>


		<div class="tortas-home-container" id="torta">
			<div class="header-tortas">
				<div class="input-search-tortas">
					<i class="fas fa-search"></i>
					<input type="text" placeholder="Buscar">
				</div>
				<div class="cart-tortas" onclick="mostrar(2)">
					<img src="https://i.ibb.co/7N4dz1s/shopping-cart-1.png" alt="shopping-cart-1">
				</div>
			</div>
			<div class="tortas-promotions">
				<div class="day-promo-2"></div>
				<div class="day-promo"></div>
			</div>
			<div class="categories-container">
				<h4>Categorías</h4>
				<div class="category-collection" >
					<div class="category-item" onclick="mostrar(2)">
						<div class="circle-item custom-1">
							<img src="https://i.ibb.co/3pPGmQb/birthday-cake.png" alt="birthday-cake" >
						</div>
						<h4>Pudding</h4>
					</div>
					<div class="category-item" onclick="mostrar(2)">
						<div class="circle-item custom-2">
							<img src="https://i.ibb.co/mtkbc9s/cupcake.png" alt="cupcake">
						</div>
						<h4>Cupcake</h4>
					</div>
					<div class="category-item" onclick="mostrar(2)">
						<div class="circle-item custom-3">
							<img src="https://i.ibb.co/tqGx0Dq/bread.png" alt="bread">
						</div>
						<h4>Bread</h4>
					</div>
					<div class="category-item" onclick="mostrar(2)">
						<div class="circle-item custom-4">
							<img src="https://i.ibb.co/b61M38Y/coffee-cup.png" alt="coffee-cup">
						</div>
						<h4>Coffe</h4>
					</div>
				</div>
			</div>
			<div class="container-products">
				<h4>Productos destacados</h4>
				<div class="products-grid">
					<div class="single-product" onclick="mostrar(3)">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/files/img-1_116fde62-b312-40b1-b08e-ff50c5cea562_360x.jpg?v=1534416978">
						<div class="hearth-icon">
							<i class="fas fa-heart"></i>
						</div>
						<div class="metadata">
							<h5>Sweet cake</h5>
							<h6>25.000</h6>
						</div>
					</div>
					<div class="single-product" onclick="mostrar(3)">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/products/product9_800x.jpg?v=1531810852">
						<div class="hearth-icon">
							<i class="fas fa-heart"></i>
						</div>
						<div class="metadata">
							<h5>Birthdate cake</h5>
							<h6>14.000</h6>
						</div>
					</div>
					<div class="single-product" onclick="mostrar(3)">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/files/img-3_f5666565-c070-4664-8562-b91db787caf3_360x.jpg?v=1534415048">
						<div class="hearth-icon">
							<i class="fas fa-heart"></i>
						</div>
						<div class="metadata">
							<h5>Muffin cake</h5>
							<h6>18.000</h6>
						</div>
					</div>
					<div class="single-product" onclick="mostrar(3)">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/files/img-2_f2039377-2a01-4fd2-b6a3-8c89873ddf18_360x.jpg?v=1534416990">
						<div class="hearth-icon">
							<i class="fas fa-heart"></i>
						</div>
						<div class="metadata">
							<h5>Hot muffin cake</h5>
							<h6>27.000</h6>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="all-products" id="torta-list" style="display: none;">
			<div class="header-products">
				<h4>Productos</h4>
			</div>
			<div class="filter-collection">
				<h4>Todos</h4>
				<h4>Populares</h4>
				<h4>Recomendados</h4>
				<h4>Más vendidos</h4>
			</div>
			<div class="inner-all-products">
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/products/p6_cfa55e6f-3b8c-4c7a-8e6e-092809ed8d4b_380x446.jpg?v=1535529185" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Pancake</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>23.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/products/product26.jpg?v=1531810845" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Birthdate cake</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>27.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/products/product2.jpg?v=1531810844" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Vinta coffe</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>16.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/products/product31.jpg?v=1531810838" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Pancake</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>23.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/0013/7487/9814/products/product34.jpg?v=1531810837" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Sweet cake</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>8.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/1284/6493/products/products21_600x.jpg?v=1467890620" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Hot muffin cake</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>14.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
				<div class="single-list-product" onclick="mostrar(3)">
					<div class="product-image">
						<img src="https://cdn.shopify.com/s/files/1/1284/6493/products/products17_600x.jpg?v=1467890195" alt="">
					</div>
					<div class="product-information">
						<div class="name-product">
							<h4>Birth cake</h4>
							<i class="fas fa-heart"></i>
						</div>
						<h5>23.000</h5>
						<div class="stars-detail">
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<i class="fas fa-star"></i>
							<h4>4.9</h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="finish-payment" id="pay" style="display: none;">
			<div class="header-products">
				<h4>Finalizar orden</h4>
			</div>
			<div class="step-container">
				<div class="single-step">
					<i class="fas fa-check"></i>
				</div>
				<hr>
				<div class="single-step">
					<i class="fas fa-check"></i>
				</div>
				<hr>
				<div class="single-step">
					<i class="fas fa-check"></i>
				</div>
				<hr>
				<div class="single-step last">
					<i class="fas fa-check"></i>
				</div>
			</div>
			<div class="names">
				<h4>Datos</h4>
				<h4>Envío</h4>
				<h4>Pago</h4>
				<h4>Entrega</h4>
			</div>
			<div class="basic-data">
				<h4>Información personal</h4>
				<h5><span>Nombre:</span> Luis Aponte</h5>
				<h5><span>Dirección:</span> Altos de Comfacesar</h5>
				<h5><span>Teléfono:</span> 3218247632</h5>
			</div>
			<div class="spacer"></div>
			<div class="basic-data">
				<div class="cart-detail">
					<div class="cart-image">
						<img src="https://i.ibb.co/7N4dz1s/shopping-cart-1.png" alt="shopping-cart-1">
					</div>
					<div class="cart-information">
						<h4>4 productos en tu carrito</h4>
					</div>
				</div>
			</div>
			<div class="spacer"></div>
			<div class="basic-data">
				<h4>Método de pago</h4>
				<h5><span>No. de cuenta:</span> 928397657</h5>
				<h5><span>Método de pago:</span> Transferencia</h5>
				<h5><span>Referencia de pago:</span> 2910829893284</h5>
				<h5><span>Total:</span> $35.000</h5>
			</div>
			<div class="container-button">
				<button class="confirm">Confirmar pedido</button>
			</div>
			
		</div>

		<div class="navigation-menu" id="nav">
			
			<img src="https://i.ibb.co/ZX45qWH/home-img.png" alt="home-img" onclick="mostrar(1)">
			<img src="https://i.ibb.co/mRpx54g/love.png" alt="love" onclick="mostrar(2)">
			<img src="https://i.ibb.co/R2nd9GL/user-img.png" alt="user-img">
			<img src="https://i.ibb.co/SsPdz3L/shopping-cart.png" alt="shopping-cart" onclick="mostrar(2)">
		</div>
	</div>
	

	<style type="text/css">

		@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

		*{
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}

		*:focus{
			outline: none !important;
		}

		.spacer{
			width: 100%;
			margin-bottom: 20px;
		}

		.custom-1{
			background: #66CE9B !important;
		}

		.custom-2{
			background: #A8D5F2 !important;
		}

		.custom-3{
			background: #F87BA1 !important;
		}

		.custom-4{
			background: #04BABC !important;
		}

		.finish-payment{
			width: 100%;
			height: 90vh;
			overflow-y: auto;
			background: #FAF9FF;
			display: block;
		}

		.step-container{
			width: 100%;
			height: auto;
			padding: 35px 20px 8px 20px;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-wrap: nowrap;
		}

		.step-container hr{
			height: 5px;
			background:#565656;
			opacity: .5;
			width: 15%;
		}

		.single-step{
			text-align: center;
		}

		.last i{
			color: transparent !important;
			border: 3px solid #04BABC;
			background: transparent !important;
		}

		.single-step i{
			background: #04BABC;
			color: #fff;
			padding: 10px;
			border-radius: 50%;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			font-size: 16px;
			margin: 0 auto;
		}

		.names{
			width: 100%;
			display: flex;
			justify-content: space-between;
			padding: 0px 35px;
			margin-bottom: 20px;
		}

		.names h4{
			font-size: 17px;
			font-weight: 500;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.basic-data{
			width: 90%;
			background: #fff;
			height: auto;
			border-radius: 10px;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			margin: 0 auto;
			padding: 25px 20px; 
		}

		.basic-data h4{
			font-size: 18px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.basic-data h5{
			font-size: 16px;
			font-weight: 500;
			color: #565656;
			font-family: 'Poppins', sans-serif;
			margin-top:  5px;
		}

		.basic-data span{
			font-weight: 600;
		}

		.container-button{
			width: 100%;
			padding: 20px 0px 95px 0px;
			text-align: center;
		}

		.confirm{
			width: 90%;
			height: auto;
			margin: 0 auto;
			border: none;
			border-radius: 15px;
			padding: 15px 0px;
			background: #04BABC;
			color: #fff;
			font-family: 'Poppins', sans-serif;
			font-size: 18px;
			font-weight: 500;
		}

		.cart-detail{
			width: 100%;
			height: auto;
			display: flex;
			justify-content: flex-start;
			align-items: center;
			flex-wrap: nowrap;
		}

		.cart-image{
			width: 50px;
			height: 50px;
			text-align: center;
			background: #04BABC;
			border-radius: 50%;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.cart-image img{
			width: 45%;
			height: auto;
		}

		.cart-information{
			width: 85%;
			text-align: left;
			padding: 0px 15px;
		}

		.cart-information h4{
			font-size: 17px;
			font-weight: 500;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}


		.tortas-home-container{
			width: 100%;
			height: 90vh;
			overflow-y: auto;
			background: #FAF9FF;
			display: block;
		}

		.header-tortas{
			width: 100%;
			height: auto;
			background: #04BABC;
			padding: 20px 15px 40px 15px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: nowrap;
		}

		.input-search-tortas{
			width: 83%;
			text-align: center;
			background: rgba(255, 255, 255, .35);
			border-radius: 25px;
			text-align: left;
			padding: 13px 20px;
			display: flex;
			justify-content: flex-start;
			align-items: center;
			flex-wrap: nowrap;
		}

		.cart-tortas{
			width: 15%;
			padding: 10px;
			text-align: center;
		}

		.cart-tortas img{
			width: 88%;
			height: auto;
		}

		.input-search-tortas i{
			color: #fff;
			font-size: 16px;
		}

		.input-search-tortas input{
			border: none;
			background: transparent;
			color: #fff;
			font-size: 17px;
			font-family: 'Poppins', sans-serif;
			padding: 0px 12px;
		}


		::placeholder{
			color: #fff;
		}

		.tortas-promotions{
			width: 100%;
			background: #FAF9FF;
			height: auto;
			border-top-left-radius: 10px;
			border-top-right-radius: 10px;
			margin-top: -22px;
    		white-space: nowrap;
    		overflow-y: hidden;
    		overflow-x: auto;
    		text-align: left;
			padding: 20px 15px;
		}

		.day-promo{
			width: 95%;
			height: 16vh;
			background: red;
			border-radius: 10px;
			display: inline-block;
			margin-right: 10px;
			background: url("https://cdn.shopify.com/s/files/1/1284/6493/files/slide_1.jpg?v=1530955057");
			background-size: cover;
			background-position: center center;
			background-repeat: no-repeat;
			box-shadow: rgba(0, 0, 0, 0.04) 0px 3px 5px;
		}

		.day-promo-2{
			width: 95%;
			height: 16vh;
			background: red;
			border-radius: 10px;
			display: inline-block;
			margin-right: 10px;
			background: url("https://opencart.opencartworks.com/themes/so_cakeshop/image/cache/catalog/slideshow/home3/slide1-1903x850.jpg");
			background-size: cover;
			background-position: center center;
			background-repeat: no-repeat;
			box-shadow: rgba(0, 0, 0, 0.04) 0px 3px 5px;
		}

		.circle-item{
			width: 70px;
			height: 70px;
			border-radius: 50%;
			background: #04A384;
			margin: 0 auto;
			text-align: center;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-wrap: nowrap;
			margin-bottom: 5px;
			box-shadow: rgba(0, 0, 0, 0.04) 0px 3px 5px;
		}

		.circle-item img{
			width: 45% !important;
			height: auto;
		}

		.container-products{
			width: 100%;
			height: auto;
			text-align: left;
			padding: 10px 15px;
		}

		.container-products h4{
			font-size: 19px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.products-grid{
			width: 100%;
			padding: 10px 0px;
			height: auto;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
		}

		.single-product{
			width: 48%;
			background: #fff;
			border-radius: 10px;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			margin-bottom: 15px;
		}

		.single-product img{
			width: 100%;
			border-bottom-right-radius: 10px;
			border-bottom-left-radius: 10px;
			border-radius: 10px;
			max-height: 180px;
		}

		.hearth-icon{
			width: 100%;
			text-align: right;
			padding: 0px 20px;
			margin-top: -20px;
		}

		.hearth-icon i{
			background: #fff;
			color: #FF7BA2;
			padding: 10px;
			border-radius: 50%;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			font-size: 16px;
		}

		.metadata{
			width: 100%;
			text-align: left;
			padding: 0px 10px 20px 10px;
		}

		.metadata h5{
			font-size: 17px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.metadata h6{
			font-size: 14px;
			font-weight: 600;
			color: #FF7BA2;
			font-family: 'Poppins', sans-serif;
		}

		.all-products{
			width: 100%;
			height: 90vh;
			overflow-y: auto;
			background: #FAF9FF;
			display: block;
		}

		.header-products{
			width: 100%;
			height: auto;
			text-align: center;
			padding: 18px 0px;
			background: #04BABC;
		}

		.header-products h4{
			font-size: 19px;
			font-weight: 600;
			color: #fff;
			font-family: 'Poppins', sans-serif;
		}

		.inner-all-products{
			width: 100%;
			height: auto;
			display: block;
			padding: 10px 20px;
		}

		.single-list-product{
			width: 100%;
			background: #fff;
			border-radius: 10px;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-wrap: nowrap;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			margin-bottom: 10px;
		}

		.product-image{
			width: 28%;
		}

		.product-image img{
			width: 100%;
			height: auto;
		}

		.product-information{
			width: 72%;
			text-align: left;
			padding: 0px 10px;
		}

		.name-product{
			width: 100%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0px 20px 0px 0px;
		}

		.name-product h4{
			font-size: 17px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.name-product i{
			background: #EC8B7A;
			color: #fff;
			padding: 10px;
			border-radius: 50%;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
			font-size: 14px;
		}

		.product-information h5{
			font-size: 16px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}


		.price{
			width: 100%;
			height: auto;
			text-align: left;
		}

		.price h4{
			color: #EC8B7A;
			font-family: 'Poppins', sans-serif;
			font-size: 21px;
			font-weight: 600;
		}





































		.mobile-app-container{
			width: 100%;
			height: auto;
			background: #FAF9FF;
			padding: 0;
			margin: 0;
		}

		.app-inner-container{
			width: 100%;
			height: auto;
			padding: 20px 15px;
		}

		.app-header{
			width: 100%;
			text-align: left;
			display: block;
		}

		.app-header h4{
			font-size: 27px;
			font-weight: 400;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.app-header h5{
			font-size: 25px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}


		.single-item-sale h6{
			font-size: 15px;
			font-weight: 500;
			color: #5D5C5C;
			font-family: 'Poppins', sans-serif;
			margin-top: 10px;
		}

		.search-container{
			width: 100%;
			height: auto;
			display: flex;
			justify-content: flex-start;
			align-items: center;
			background: #F7F7F7;
			border-radius: 13px;
			margin-top: 16px;
			padding: 19px 16px;
		}


		.search-container input{
			width: 90%;
			background: transparent;
			border: none;
			font-family: 'Poppins', sans-serif;
			font-size: 17px;
			color: #B9B9B9;
		}

		.search-container i{
			color: #B9B9B9;
			font-size: 19px;
			margin-right: 15px;
		}

		

		.navigation-menu{
			background: #fff;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
			display: flex;
			justify-content: space-around;
			align-items: center;
			padding: 28px 10px;
			width: 100%;
			border-top-left-radius: 15px;
			border-top-right-radius: 15px;
			position: fixed;
			bottom: 0;
		}

		/*.navigation-menu i{
			color: #fff;
			opacity: .9;
			font-size: 21px;
		}*/

		.navigation-menu img{
			width: 8%;
		}

		.categories-container{
			width: 100%;
			text-align: left;
			display: block;
			padding: 5px 0px;
		}

		.categories-container h4{
			font-size: 19px;
			font-weight: 600;
			padding: 0px 15px;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.popular-container{
			width: 100%;
			text-align: left;
			display: block;
			padding: 20px 0px;
		}

		.popular-container h4{
			font-size: 22px;
			font-weight: 600;
			color: #565656;
			font-family: 'Poppins', sans-serif;
		}

		.popular-collection{
    		white-space: nowrap;
    		overflow-y: hidden;
    		overflow-x: auto;
    		text-align: left;
    		padding: 5px 0px;
		}

		.name-collection{
			background: #fff;
    		white-space: nowrap;
    		overflow-y: hidden;
    		overflow-x: auto;
    		text-align: left;
    		padding: 25px 0px;
		}

		.name-collection h4{
			margin-right: 13px;
    		display: inline-block;
    		font-size: 14px;
			font-weight: 500;
			color: #DCDCDC;
			font-family: 'Poppins', sans-serif;
		}

		.name-collection h4:nth-child(1){
			color:#EF7D00;
			font-weight: 600;
		}

		.category-collection{
    		white-space: nowrap;
    		overflow-y: hidden;
    		overflow-x: auto;
    		text-align: left;
    		padding: 10px 0px 0px 0px;
		}

		.category-item{
			width: 22%;
			text-align: center;
			margin-right: 15px;
    		display: inline-block;
		}

		.category-item h4{
			font-size: 16px;
			font-weight: 500;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.category-item img{
			width: 100%;
			height: auto;
		}

		.single-popular{
			width: 48%;
			border-radius: 10px;
			padding: 8px 8px 22px 8px;
			border: 1px solid #F5F5F5;
			margin-right: 15px;
    		display: inline-block;
    		box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
		}

		.single-popular img{
			width: 100%;
			height: auto;
			border-radius: 10px;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
		}

		.single-popular h4{
			font-size: 16px;
			font-weight: 600;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.single-popular h5{
			font-size: 14px;
			font-weight: 500;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}


		/*Estilos interna de busqueda*/

		.inner-container-search{
			width: 100%;
			height: auto;
			padding: 20px 15px;
		}

		.filter-collection{
    		white-space: nowrap;
    		overflow-y: hidden;
    		overflow-x: auto;
    		text-align: left;
    		padding: 25px 10px;
		}

		.filter-collection h4{
			margin-right: 13px;
    		display: inline-block;
    		font-size: 14px;
			font-weight: 500;
			color: #04BABC;
			border: 1px solid #04BABC;
			font-family: 'Poppins', sans-serif;
			background: transparent;
			padding: 9px 16px;
			border-radius: 19px;
		}

		.filter-collection h4:nth-child(1){
			background: #04BABC;
			color: #fff;
		}

		.all-results{
			width: 100%;
			height: auto;
			display: block;
			padding-top: 15px;
		}

		.single-search-item{
			width: 100%;
			border-radius: 10px;
			padding: 8px 8px 22px 8px;
			border: 1px solid #F5F5F5;
			margin-right: 15px;
    		display: inline-block;
    		box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    		margin-bottom: 15px;
		}

		.single-search-item img{
			width: 100%;
			height: auto;
			border-radius: 10px;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
		}

		.name-price{
			width: 100%;
			height: auto;
			padding: 10px 12px 5px 12px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.stars{
			width: 100%;
			height: auto;
			padding: 10px 12px 0px 12px;
			display: flex;
			justify-content: flex-start;
			align-items: center;
		}

		.stars i{
			color: #ECA834;
		}

		.stars h4{
			color: #B9B9B9;
			font-family: 'Poppins', sans-serif;
		}

		.icons-collection{
			width: 100%;
			height: auto;
			padding: 10px 12px 0px 12px;
			display: flex;
			justify-content: flex-start;
			align-items: center;
		}

		.icons-collection i{
			color: #EF7D00;
			margin-right: 3px;
		}

		.icons-collection h4{
			font-size: 14px;
			font-weight: 500;
			color: #B9B9B9;
			font-family: 'Poppins', sans-serif;
			margin-right: 10px;
		}

		.name-price h4{
			font-size: 18px;
			font-weight: 600;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.name-price h5{
			font-size: 17px;
			font-weight: 500;
			color: #6ECFAF;
			font-family: 'Poppins', sans-serif;
		}


		/*Estilos detalle*/

		.inner-container-detail{
			width: 100%;
			height: 90vh;
			padding: 20px 15px;
			display: block;
			overflow-y: auto;
		}


		.image-detail{
			width: 100%;
			height: auto;
			position: relative;
		}

		.image-detail img{
			width: 100%;
			height: auto;
			border-radius: 28px;
		}

		.back-button-container{
			background: #fff;
			padding: 15px;
			border-radius: 50%;
			display: flex;
			justify-content: center;
			align-items: center;
			position: absolute;
			top: 15px;
			left: 18px;
		}

		.stars-detail{
			width: 100%;
			height: auto;
			padding: 5px 0px 0px 0px;
			display: flex;
			justify-content: flex-start;
			align-items: center;
		}

		.stars-detail i{
			color: #ECA834;
		}

		.stars-detail h4{
			color: #B9B9B9;
			font-family: 'Poppins', sans-serif;
			margin-left: 5px;
		}

		.service-name{
			width: 100%;
			text-align: left;
			padding-top: 20px;
		}

		.service-name h4{
			font-size: 23px;
			font-weight: 600;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.description{
			width: 100%;
			text-align: left;
			padding-top: 20px;
		}

		.description h4{
			font-size: 17px;
			font-weight: 600;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.description p{
			font-size: 15px;
			font-weight: 500;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.gallery-service{
			width: 100%;
			text-align: left;
			padding-top: 10px;
		}

		.gallery-service h4{
			font-size: 17px;
			font-weight: 600;
			color: #333333;
			font-family: 'Poppins', sans-serif;
		}

		.images-gallerys{
			width: 100%;
			height: auto;
			display: flex;
			justify-content: space-around;
			align-items: center;
			padding-top: 10px;
		}

		.images-gallerys img{
			width: 20%;
			border-radius: 15px;
			margin-right: 10px;
		}

		.option-button{
			width: 100%;
			height: auto;
			padding-top: 20px;
			padding-bottom: 95px;
			text-align: center;
		}

		.option-button button{
			width: 100%;
			background: #04BABC;
			color: #fff;
			border: none;
			cursor: pointer;
			padding: 18px 0px;
			border-radius: 28px;
			font-family: 'Poppins', sans-serif;
			font-size: 18px;
			font-weight: 500;
		}




	</style>


	<script>
		function mostrar(numero){
			if (numero == 1) {
				document.getElementById("torta").style.display = "";
				document.getElementById("torta-list").style.display = "none";
				document.getElementById("detail").style.display = "none";
				document.getElementById("pay").style.display = "none";
			}
			if (numero == 2) {
				document.getElementById("torta").style.display = "none";
				document.getElementById("torta-list").style.display = "";
				document.getElementById("detail").style.display = "none";
				document.getElementById("pay").style.display = "none";
			}
			if(numero == 3){
				document.getElementById("detail").style.display = "";
				document.getElementById("torta-list").style.display = "none";
				document.getElementById("torta").style.display = "none";
				document.getElementById("pay").style.display = "none";
			}
			if (numero == 4) {
				document.getElementById("pay").style.display = "";
				document.getElementById("torta").style.display = "none";
				document.getElementById("torta-list").style.display = "none";
				document.getElementById("detail").style.display = "none";
			}
			if (numero == 5) {
				document.getElementById("list").style.display = "none";
				document.getElementById("detail").style.display = "";
			}
			if (numero == 6) {
				document.getElementById("detail").style.display = "none";
				document.getElementById("list").style.display = "";
			}
		}
	</script>
		
		
</body>
</html>