<?php
	session_start();

	if(isset($_GET["publishNotLogged"])){
		$action = "Action/LoginAction.php?publishNotLogged=1";
	}
	else{
		$action = "Action/LoginAction.php";
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Acessar conta</title>
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
		<div class="container">
			<br>
			<button class="btn red accent-4 waves-effect waves-light right"><a href="register.php" class="white-text">Criar conta</a></button>
		</div>

		<div class="row vertical center-align">		
			<h4 class="light col s12">Login</h4>	

			<div class="col s12">
				<form action="<?php echo $action ?>" name="loginForm" id="loginForm" method="POST"> 

					<div class="input-field col s12">
						<input 
							value="<?php echo isset($_SESSION["emailError"]) ? $_SESSION["emailError"] : null; ?>"
							placeholder="" 
							type="email" 
							name="email" 
							required 
							autofocus
							class="validate">
						<label for="name">Email</label>					
					</div>

					<div class="input-field col s12">
						<input placeholder="" type="password" name="password" minlength="8" required class="validate">
						<label for="password">Senha</label>					
					</div>				

					<button type="submit" id="btnLogin" name="btnLogin" class="btn red accent-4 waves-effect waves-light">Login</button>	
				</form>	
			</div>	

			<div class="divider"></div>
			<div class="col s12 section">
				<h5 class="red-text text-accent-4">
					<?php 
						if(isset($_SESSION["loginMessage"])){ 
							echo $_SESSION["loginMessage"];							
						}
					?>
				</h5>			
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