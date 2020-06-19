<?php 
	require_once "../Classes/UserDao.php";
	session_start();

	if(isset($_POST["btnLogin"])){
		session_unset();	
		$email = clear($_POST["email"]);
		$password = md5(clear($_POST["password"]));

		$userDao = new UserDao();
		$userDao->selectUserEmail($email);

		if(isset($_SESSION["emailNotFound"])){
			$_SESSION["loginMessage"] = "O E-mail informado não foi encontrado!";			
			
			if(isset($_GET["publishNotLogged"])){
				header("Location: ../login.php?publishNotLogged=1");
			}
			else{
				header("Location: ../login.php");
			}
		}
		else if(isset($_SESSION["emailNotVerified"])){
			$_SESSION["emailError"] = $email;
			$date = strtotime($_SESSION["dateSent"]);
			$date = date("d/m/Y", $date);
			$_SESSION["loginMessage"] = "Este E-mail ainda não foi verificado! <br>Um E-mail foi enviado para <b>$email</b> no dia <b>$date</b>. <br>Certifique-se de olhar na caixa de spam.";
			
			if(isset($_GET["publishNotLogged"])){
				header("Location: ../login.php?publishNotLogged=1");
			}
			else{
				header("Location: ../login.php");
			}
		}
		else{	
			$data = $userDao->selectUser($email, $password);	
			if(isset($_SESSION["userNotFound"])){
				$_SESSION["emailError"] = $email;
				$_SESSION["loginMessage"] = "A senha inserida está incorreta!";	
				
				if(isset($_GET["publishNotLogged"])){
					header("Location: ../login.php?publishNotLogged=1");
				}
				else{
					header("Location: ../login.php");
				}					
			}
			else{							
				session_unset();
				//Logando
				$_SESSION["logged"] = true;
				//Pegando todas as informações do usuário da tabela user
				$_SESSION["userInfos"] = $data["0"];	
				
				if(isset($_GET["publishNotLogged"])){
					header("Location: ../newService.php");
				}
				else{
					header("Location: ../index.php");
				}											
			}
		}	
	}

	function clear($value){
		return trim(htmlspecialchars($value));
	}
?>