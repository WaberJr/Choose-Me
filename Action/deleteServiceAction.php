<?php 
    require_once "../Classes/ServicesDao.php";
    session_start();

    $idService = $_GET["id_service"];   

    $servicesDao = new ServicesDao();
    $servicesDao->deleteService($idService);
    
    echo var_dump($services);
    $_SESSION["myServicesMessage"] = "Anúncio eliminado com sucesso!";
    header("Location: ../myServices.php");
?>