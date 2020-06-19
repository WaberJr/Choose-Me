<?php 
    require_once "../Classes/Services.php";
    require_once "../Classes/ServicesDao.php";
    session_start();

    $title = clear($_POST["title"]);
    $description = htmlspecialchars($_POST["description"]);
    $type = clear($_POST["type"]);
	$cep = clear($_POST["cep"]);
	$neighborhood = clear($_POST["neighborhood"]);
    $state = clear($_POST["state"]);
    $city = clear($_POST["city"]);
    $phone = clear($_POST["phone"]);
    $hidePhone = isset($_POST["hidePhone"]) ? clear($_POST["hidePhone"]) : "0";
    $idUser = $_SESSION["userInfos"]["id_user"];
    $identifier = md5(time().$idUser);
    $error = false;

    if(strlen($phone) > 0 and strlen($phone) < 14){
        $_SESSION["newServiceMessage"] = "Telefone inválido";  
        $error = true;                
		header("Location: ../newService.php");
    }

    if(strlen($cep) > 0 and strlen($cep) < 9){
		$_SESSION["newServiceMessage"] = "CEP inválido";
		$error = true;
		header("Location: ../newService.php");
    }

    if($neighborhood == "..." or $neighborhood == ""){
		$_SESSION["newServiceMessage"] = "CEP não encontrado, favor verificar";
		$error = true;
		header("Location: ../newService.php");
    }
    
    if($error){
        $_SESSION["errorNewService"] = [
            "title" => $title,
            "description" => $description,
            "type" => $type,
            "cep" => $cep,
            "neighborhood" => $neighborhood,
            "state" => $state,
            "city" => $city,
            "phone" => $phone, 
            "hidePhone" => $hidePhone                      
        ];   
    }

    if(!$error){
        $services = new Services();
        $services->setTitle($title);
        $services->setDescription($description);
        $services->setType($type);
        $services->setCep($cep);
        $services->setNeighborhood($neighborhood);
        $services->setState($state);
        $services->setCity($city);
        $services->setPhone($phone);
        $services->setHidePhone($hidePhone);
        $services->setIdUser($idUser);
        $services->setIdentifier($identifier);

        $servicesDao = new ServicesDao();
        $servicesDao->insertService($services);

        header("Location: ../servicePosted.php");
    }

    function clear($value){
        return trim(htmlspecialchars($value));
    }
?>