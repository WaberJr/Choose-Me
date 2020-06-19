<?php 
	session_start();

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
		header("Location: home.php");
	}

	$userInfos = $_SESSION["userInfos"];
	$firstName = explode(" ", $userInfos["name"]);
	
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
		<div>
			<div class="row">
				
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
	</body>
</html>