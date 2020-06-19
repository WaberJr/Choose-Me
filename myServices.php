<?php 
	session_start();
	require_once "Classes/ServicesDao.php";
	require_once "./Classes/ServicesDao.php";
	require_once "./Classes/ServicesTypesDao.php";

	unset($_SESSION['servicesNotFound']);

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
		header("Location: home.php");
	}

	$userInfos = $_SESSION["userInfos"];
	$firstName = explode(" ", $userInfos["name"]);

	//Selecionando todos os serviços do usuário
	$servicesDao = new ServicesDao();	
	$services = $servicesDao->selectUserServices($userInfos["id_user"]);

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
		<div class="container">
			<div>
				<h5 class="center-align">
					Meus anúncios
				</h5>
			</div>
					
			<?php
			//Verifica se existe anúncio
			if(!isset($_SESSION["servicesNotFound"])){ ?>
			<div class="collection">
				<?php 
					foreach($services as $service){ 
						$date = new DateTime($service["createData"]);	
						?>	
						<a href="<?php echo "editService.php?id_service=". $service["id_service"] . "&id_user=" . $service["id_user"]?>" class="collection-item black-text"> 
							<!-- Título -->
							<h5 class="truncate"><?php echo $service["title"] ?></h5> 
							<br>
							<!-- Cidade/Estado -->
							<?php
							echo $service["city"] ." / ". $service["state"];
							?>	
							<br>
							<!-- Descrição do tipo -->
							<?php
							$typeDescription = $servicesTypesDao->selectServicesTypesById($service["type"]); 
							$typeDescription = $typeDescription[0]["description"];
							echo $typeDescription;
							?>
													

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
						<!-- Set não tiver ele simplesmente exibe a mensagem que não tem -->
						<div class="center-align vertical">
							<h4>Você ainda não possui anúncios ativos :(</h4>	
						</div>	
					<?php }
				?>
																						 
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

				//Collapsible
				$('.collapsible').collapsible();    

				//SideNav
				$('.sidenav').sidenav();   			
			});
		</script>
		<?php
			if(isset($_SESSION["myServicesMessage"])){ ?>
				<script>
					M.toast({html: '<?php echo $_SESSION["myServicesMessage"] ?>'})
				</script>		
			<?php }
			unset($_SESSION["myServicesMessage"]);
		?>
	</body>
</html>