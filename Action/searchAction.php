<?php 
    require_once "../Classes/ServicesDao.php";
    session_start();
    unset($_SESSION["serviceNotFound"]);

    $servicesDao = new ServicesDao();

    //Busca pelo termo de pesquisa
    if(isset($_GET["search"])){
        $search = $_GET["search"];
        $result = $servicesDao->selectAllServicesWhere($search);
    }

    //Busca pela UF
    if(isset($_GET["uf"])){
        $uf = $_GET["uf"];
        $result = $servicesDao->selectServiceByUf($uf); 
    }
?>