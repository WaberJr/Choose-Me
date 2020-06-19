<?php 
	session_start();
	require_once "./Classes/UfDao.php";
	require_once "./Classes/ServicesDao.php";
	require_once "./Classes/ServicesTypesDao.php";
	unset($_SESSION["serviceNotFound"]);

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
		header("Location: home.php");
	}	

	$userInfos = $_SESSION["userInfos"];
	$firstName = explode(" ", $userInfos["name"]);
	
	//Pegando as UF's
	$ufDao = new UfDao();
	$ufs = $ufDao->selectUf();

	//Pegando os últimos 10 anúncios
	$servicesDao = new ServicesDao();
	$top6Services = $servicesDao->selectTop6Services();	

	$servicesTypesDao = new ServicesTypesDao();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>ChooseMe</title>
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="customCSS/customCSS.css">
	</head>
	<body>
		<!-- Header-->
		<nav class="red accent-4">
			<div class="nav-wrapper container">
				<a href="index.php" class="brand-logo left"><i class="material-icons">work</i>ChooseMe</a>
				<a href="#" data-target="mobile-demo" class="right sidenav-trigger"><i class="material-icons">menu</i></a>
				<ul class="right">
					<li>
						<a href="newService.php">
							Anunciar serviço
						</a>
					</li>	        	
					<li>	        		
						<a class="dropdown-trigger hide-on-med-and-down" data-target="dropdown1" data-beloworigin="true">	
							<i class="material-icons left">account_circle</i>	              	
							Olá <?php echo $firstName[0]; ?>!
							<i class="material-icons right">arrow_drop_down</i>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<!--NavBar DropDown Content -->
		<ul id="dropdown1" class="dropdown-content">
			<!-- Modal Trigger -->
			<li><a href="myServices.php">Meus anúncios</a></li>
			<li><a href="editProfile.php">Meu perfil</a></li>
			<li><a href="Action/LogoutAction.php">Sair</a></li>
		</ul>

		<!--SideNav Content -->
		<ul class="sidenav" id="mobile-demo">
			<ul class="center-align"><h5>ChooseMe</h5></ul>
			<hr>
			<ul class="collapsible">
				<li>
					<!-- Collapasible Header -->
					<div class="collapsible-header">	
						<i class="material-icons left">account_circle</i>	              	
							Olá <?php echo $firstName[0]; ?>!
						<i class="material-icons right">arrow_drop_down</i>
					</div>

					<!-- Collapasible body -->
					<div class="collapsible-body">
						<ul>
							<li><a href="myServices.php">Meus anúncios</a></li>
							<li><a href="editProfile.php">Meu perfil</a></li>
							<li><a href="Action/LogoutAction.php">Sair</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</ul>

		<!-- Content --> 
		<br>
		<div class="nav-wrapper container z-depth-1">
			<form action="search.php?search=<?php echo  $_GET["search"] ?>" name="searchForm" id="searchForm" method="GET">
				<div class="input-field">
					<input id="search" name="search" type="search" placeholder="Busque por serviços, categorias, etc...">
					<label class="label-icon" for="search"><i class="material-icons">search</i></label>
					<i class="material-icons">close</i>
				</div>
			</form>
		</div>
		<br>

		<div class="row container">			
			<div class="col s12">
				<h5><i class="material-icons">location_on</i> Escolher meu estado:</h5>			
			</div>
	
			<div class="col s12">
				<?php 
					foreach($ufs as $uf){ ?>
						<a class="black-text" href="search.php?uf=<?php echo $uf["Uf"]; ?>"> <?php echo $uf["Uf"] != "TO" ? $uf["Uf"] ." -": "TO"?> </a>
					<?php }
				?>			
			</div>
		</div>
		<br>

		<div class="row container">			
			<div class="col s12">
				<h5><i class="material-icons">local_offer</i> Últimos anúncios:</h5>			
			</div>
	
			<div class="col s12">
				<div class="collection">
				<?php 
					if(!isset($_SESSION["serviceNotFound"])){
						foreach($top6Services as $service){ 
							$date = new DateTime($service["createData"]);	
							?>	
							<a href="<?php echo "visualizeService.php?id_service=". $service["id_service"] . "&identifier=" . $service["identifier"]?>" class="collection-item black-text"> 
								<!-- Título -->
								<h5 class="truncate"><?php echo $service["title"] ?></h5> 
								<br>
								<!-- Cidade/Estado -->
								<?php
								echo $service["city"] ." / ". $service["state"];
								?>	
								<br>
								<!-- Descrição do tipo -->
								<span class="truncate">
								<?php
								$typeDescription = $servicesTypesDao->selectServicesTypesById($service["type"]); 
								$typeDescription = $typeDescription[0]["description"];
								echo $typeDescription;
								?>
								<span>
									
								<!--Exibe apenas para telas maiores -->
								<span class="badge hide-on-small-only">
									<?php echo "Criado em: ". $date->format('d/m/y') ." às ". $date->format('H:i'); ?>
								</span>		

								<!--Exibe apenas para telas menores -->
								<span class="badge show-on-small hide-on-med-and-up">
									<?php echo $date->format('d/m/y') ." às ". $date->format('H:i'); ?>
								</span>					
							</a>
						<?php }
						}
						else{ ?>
							<div class="center-align">
								<h5>Ainda não há nenhum anúncio feito!</h5>
								<p> Não perca tempo e faça o seu primeiro anúncio.</p>	
								<p><a href="newService.php" class="btn red accent-4 waves-effect waves-light white-text">Crie um anúncio agora!</a></p>					
							</div>
						<?php }
					?>
				</div>
			</div>
		</div>
		<br>
						
 
		<div>
			<div class="parallax-container">
				<div class="parallax">	 			
					<img class="responsive-img" src="images/homeImage1.jpg">
				</div> 		
			</div>
		</div>
		<br>
		<div class="row">
			<a><i class="black-text material-icons">keyboard_arrow_down</i></a>		
		</div>
		<div class="section white scrollspy">
			<div class="row container center-align ">
				<h3 class="header"/>Seja você o seu patrão</h3>
				<p class="grey-text text-darken-3">Defina o dia, hora e lugar que você deseja trabalhar.</p>
			</div>
		</div>
		<div>
			<div class="parallax-container">
				<div class="parallax">	 			
					<img class="responsive-img" src="images/homeImage2.jpg">
				</div> 		
			</div>
		</div>
		<div class="section white">
			<div class="row container center-align">
				<h3 class="header">Gratuito</h3>
				<p class="grey-text text-darken-3 lighten-3">Cadastre-se agora e comece a ganhar dinheiro por conta própria.</p>
			</div>
		</div> 

		<!-- Footer -->
		<footer class="page-footer red accent-4">
			<div class="footer-copyright red accent-4 white-text">
				<div class="container center-align">
					Powered By Waber Jr.
				</div>
			</div>
		</footer>
		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script>
			$(document).ready(function(){	
				//NavBar Dropdown
				$(".dropdown-trigger").dropdown({
					coverTrigger: false,
				});       

				//Home Slider
				$('.slider').slider();

				//SideNav
				$('.sidenav').sidenav();

				//collapsible
				$(document).ready(function(){
					$('.collapsible').collapsible();
				});

				//Parallax
				$('.parallax').parallax();				
			});
		</script>
	</body>
</html>