<?php 
    require_once "../Classes/ServicesDao.php";
    session_start();

    $idService = $_GET["id_service"];   

    $servicesDao = new ServicesDao();
    $servicesDao->deleteService($idService);
    
    echo var_dump($services);
    header("Location: ../myServices.php");
?>