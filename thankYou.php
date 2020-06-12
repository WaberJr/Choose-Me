<?php
    session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Obrigado!</title>
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="customCSS/customCSS.css">
	</head>
	<body>
		<!-- Header-->
		<nav class="red accent-4">
			<div class="nav-wrapper container">
					<a href="home.php" class="center brand-logo">ChooseMe</a>		    	  	
			</div>
		</nav>

		<!-- Content -->
		<div class="row container center-align vertical">
			<div class="col s12 light">
					<h5>Obrigado por se registrar! Nós enviamos um E-mail de verificação para o endereço informado.</h5>
				<h5>Certifique-se de olhar na caixa de spam.</h5>
			</div>

			<div class="col s12">
				<i class="material-icons large">mail</i>
			</div>

			<div class="col s12">
				<button class="btn red accent-4 waves-effect waves-light "><a href="home.php" class="white-text">Voltar para o início</a></button>
			</div>
		</div>
		
		<!-- Footer -->
		<footer class="page-footer red accent-4">
			<div class="footer-copyright red accent-4">
				<div class="container center-align">
						Powered By Waber Jr.
				</div>
			</div> 
		</footer>
		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>	
		<script src="http://malsup.github.com/jquery.form.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> 
	</body>
</html>