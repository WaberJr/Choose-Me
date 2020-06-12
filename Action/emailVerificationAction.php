<?php 
	session_start();
	require_once "Classes/UserDao.php";

	if(isset($_GET["vkey"])){
		session_unset();	
		$vKey = $_GET["vkey"];

		$userDao = new UserDao();
		$userDao->selectVerifyUser($vKey);

		if(isset($_SESSION["verificationNotFound"])){
			$_SESSION["verificationMessage"] = "Esta conta é inválida ou já foi verificada!";
		}
		else{
			$userDao->verifyUser($vKey);
			$_SESSION["verificationMessage"] = "Sua conta foi verificada. Você pode acessá-la agora!";			
		}	
	}
	else{
		$_SESSION["verificationMessage"] = "Algo deu errado!";
	}
?>