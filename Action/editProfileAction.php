<?php
	session_start(); 	
	require_once "../Classes/User.php";
	require_once "../Classes/UserDao.php";
	 
	$name = clear($_POST["name"]);
	$phone = clear($_POST["phone"]);
	$cep = clear($_POST["cep"]);
	$street = clear($_POST["street"]);
	$number = clear($_POST["number"]);
	$neighborhood = clear($_POST["neighborhood"]);
	$complement = clear($_POST["complement"]);
	$city = clear($_POST["city"]);
	$state = clear($_POST["state"]);
	$cpf = clear($_POST["cpf"]);
	$rg = clear($_POST["rg"]);
 
	$user = new User();
	$userDao = new UserDao();

	$idUser = $_SESSION["userInfos"]["id_user"];
	$user->setName($name);
	$user->setCpf($cpf);
	$user->setRg($rg);
	$error = false;


	if(strlen($cpf) > 0 and strlen($cpf) < 14){
		$_SESSION["editProfileMessage"] = "CPF inválido";
		$error = true;
		header("Location: ../editProfile.php");
	}

	if(strlen($cep) > 0 and strlen($cep) < 9){
		$_SESSION["editProfileMessage"] = "CEP inválido";
		$error = true;
		header("Location: ../editProfile.php");
	}

	if(strlen($phone) > 0 and strlen($phone) < 14){
		$_SESSION["editProfileMessage"] = "Telefone inválido";
		$error = true;
		header("Location: ../editProfile.php");
	}

	if($error == false){		
		$userDao->udpateUserData($user, $idUser);
		
		if(is_array($userDao->selectUserAddress($idUser))){
			$userDao->udpateUserAddress($cep, $street, $number, $neighborhood, $complement, $city, $state, $idUser);
		}
		else{
			$userDao->insertUserAddress($cep, $street, $number, $neighborhood, $complement, $city, $state, $idUser);
		}		

		if(strlen($phone) >= 14){			 			
			if(is_array($userDao->selectUserPhones($idUser))){
				$userDao->updateUserPhone($phone, $idUser);
			}else{
				$userDao->insertUserPhone($phone, $idUser);
			}						
		}
		else{
			$userDao->deleteUserPhone($idUser);
		}		

		$_SESSION["editProfileMessage"] = "Dados salvos com sucesso!";
		header("Location: ../editProfile.php");
	}

	 
	function clear($value){
		return trim(htmlspecialchars($value));
	}
?>



