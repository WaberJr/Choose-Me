<?php 
	session_start();
	require_once "../Classes/User.php";
	require_once "../Classes/UserDao.php";
	require_once "sendEmailAction.php";

	if(isset($_POST["btnRegister"])){	
		$name = clear($_POST["name"]);
		$email = clear($_POST["email"]);
		$password = md5(clear($_POST["password"]));
		$confirmPassword = md5(clear($_POST["confirmPassword"]));
		$vKey = md5(time().$name);

		if(!emailValidation($email)){
			$_SESSION["registerMessage"] = "Insira um E-mail válido!";
			$_SESSION["nameError"] = $name;
			$_SESSION["emailError"] = $email;
			header("Location: ../register.php");
		}
		else if($password != $confirmPassword){
			$_SESSION["registerMessage"] = "As duas senhas não são idênticas";
			$_SESSION["nameError"] = $name;
			$_SESSION["emailError"] = $email;
			header("Location: ../register.php");
		}
		else{	
			$userDao = new UserDao();
			$userDao->selectUserEmail($email);
			if(isset($_SESSION["emailNotFound"])){		
				//Adicionar no banco de dados
				$user = new User();
				$user->setName($name);
				$user->setEmail($email);
				$user->setPassword($password);
				$user->setVKey($vKey);

				$userDao->insert($user);

				//Enviando o E-mail de verificação
				sendEmail($email, $vKey);
			}
			else{
				if(isset($_SESSION["emailNotVerified"])){
					$date = strtotime($_SESSION["dateSent"]);
					$date = date("d/m/Y", $date);
					$_SESSION["registerMessage"] = "Este E-mail já foi utilizado mas ainda não foi verificado! <br>Um E-mail foi enviado para <b>$email</b> no dia <b>$date</b>. <br>Certifique-se de olhar na caixa de spam.";
					header("Location: ../register.php");
				}
				else{
					if($_SESSION["emailVerified"]){
						$_SESSION["registerMessage"] = "Este E-mail já foi utilizado!";
						header("Location: ../register.php");
					}
				}
			}						
		}										
	}

	function clear($value){
		return trim(htmlspecialchars($value));
	}

	function emailValidation($email){
	    return filter_var(clear($email), FILTER_VALIDATE_EMAIL);
	}	
?>





