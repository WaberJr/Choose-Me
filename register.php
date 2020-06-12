<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Registre-se</title>
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link rel="stylesheet" href="">
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

		<!-- Register Form -->
		<div class="row center-align vertical">
			<h4 class="light col s12">Experimente grátis o ChooseMe</h4>			

			<div class="col s12">
				<form action="Action/RegisterAction.php" name="registerForm" id="registerForm" method="POST">

					<div class="input-field">
						<input 
							value="<?php echo isset($_SESSION["nameError"]) ? $_SESSION["nameError"] : null; ?>"
							placeholder="" 
							type="text" 
							name="name"  
							minlength="4" 
							required 
							autofocus 
							class="validate">
						<label for="name">Nome</label>					
					</div>

					<div class="input-field">
						<input 
							value="<?php echo isset($_SESSION["emailError"]) ? $_SESSION["emailError"] : null; ?>"
							placeholder="" 
							type="email" 
							name="email" 
							required 
							class="validate">
						<label for="email">Email</label>					
					</div>
		
					<div class="input-field">
						<input placeholder="" type="password" name="password" id="password" minlength="8" required class="validate">
						<label for="password">Senha</label>					
					</div>

					<div class="input-field">
						<input placeholder="" type="password" name="confirmPassword" id="confirmPassword" minlength="8" required class="validate">
						<label for="confirmPassword">Confirmar senha</label>					
					</div>

					<button type="submit" id="btnRegister" name="btnRegister" class="btn waves-effect waves-light red accent-4">Cadastrar</button>				
				</form>			
			</div>

			<div class="divider"></div>
			<div class="col s12 section">
				<h5 class="red-text text-accent-4">
					<?php 
						if(isset($_SESSION["registerMessage"])){ 
							echo $_SESSION["registerMessage"];
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
		<script src="javascript/register.js"></script>
	</body>
</html>