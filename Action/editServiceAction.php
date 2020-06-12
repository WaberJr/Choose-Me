<?php 
    require_once "../Classes/Services.php";
    require_once "../Classes/ServicesDao.php";
    session_start();

    $title = clear($_POST["title"]);
    $description = clear($_POST["description"]);
    $type = clear($_POST["type"]);
	$cep = clear($_POST["cep"]);
	$neighborhood = clear($_POST["neighborhood"]);
    $state = clear($_POST["state"]);
    $city = clear($_POST["city"]);
    $phone = clear($_POST["phone"]);
    $hidePhone = isset($_POST["hidePhone"]) ? clear($_POST["hidePhone"]) : "0";
    $idService = clear($_POST["id_service"]);
    $error = false;


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
        $services->setIdService($idService);

        $servicesDao = new ServicesDao();
        $servicesDao->udpateService($services);

        echo var_dump($services);
        //header("Location: ../editService.php?id_service=". $idService);
    }

    function clear($value){
        return trim(htmlspecialchars($value));
    }
?>