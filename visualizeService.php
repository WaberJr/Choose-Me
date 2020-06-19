<?php 
    require_once "./Classes/ServicesDao.php";
    require_once "./Classes/UserDao.php";
    require_once "./Classes/ServicesTypesDao.php";

	session_start();

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
        if(!isset($_GET["notLogged"])){
            header("Location: home.php");
        }	
    }
    else{
        $userInfos = $_SESSION["userInfos"];
        $firstName = explode(" ", $userInfos["name"]);
    }

    //Pegando os dados do anúncio clicado
    $servicesDao = new ServicesDao();
    $service = $servicesDao->selectByIdServiceAndIdentifier($_GET["id_service"], $_GET["identifier"]);
    if(!isset($_SESSION["serviceNotFound"])){
        $service = $service[0];
    }
    else{
        header("Location: index.php");
    }
        
    //Pegando os dados de quem fez o anúncio
    $userDao = new UserDao();
    $serviceUser = $userDao->selectUserById($service["id_user"]);
    $serviceUser = $serviceUser[0];

    //Pegando a descrição do tipo de serviço
    $servicesTypesDao = new ServicesTypesDao();
    $serviceDescription = $servicesTypesDao->selectServicesTypesById($service["type"]);
    $serviceDescription = $serviceDescription[0]["description"];

    //Formatando a data
    $date = new DateTime($service["createData"]);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>ChooseMe</title>
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="customCSS/customCSS.css">
	</head>
	<body>
		<!-- Header-->
		<nav class="red accent-4">
			<div class="nav-wrapper container">
				<a href="index.php" class="brand-logo left"><i class="material-icons">work</i>ChooseMe</a>
				<a href="#" data-target="mobile-demo" class="right sidenav-trigger"><i class="material-icons">menu</i></a>
				<ul class="right">
					<li>
						<a href="newService.php">
							Anunciar serviço
						</a>
                    </li>
                    <?php   
                        //Verifica se está logado para exibir de forma correta
                        if(isset($_GET["notLogged"])){ ?>
                            <!-- Dropdown Trigger -->
                            <li>
                                <a class="dropdown-trigger hide-on-med-and-down" data-target="dropdown1" data-beloworigin="true">Comece agora!
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        <?php }
                        //Se estiver logado carrega os dados do perfil
                        else{ ?>
                            <li>	        		
                                <a class="dropdown-trigger hide-on-med-and-down" data-target="dropdown1" data-beloworigin="true">	
                                    <i class="material-icons left">account_circle</i>	              	
                                    Olá <?php echo $firstName[0]; ?>!
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        <?php }
                    ?>	        						
				</ul>
			</div>
        </nav>

        <!--NavBar DropDown Content -->           
        <?php
            //Verifica se está logado para exibir de forma correta
            if(isset($_GET["notLogged"])){ ?>
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="login.php">Acessar conta</a></li>
                    <li><a href="register.php">Registre-se</a></li>
                </ul>
            <?php }
            //Se estiver logado carrega os dados do perfil
            else{ ?>
                <ul id="dropdown1" class="dropdown-content">
                    <!-- Modal Trigger -->
                    <li><a href="myServices.php">Meus anúncios</a></li>
                    <li><a href="editProfile.php">Meu perfil</a></li>
                    <li><a href="Action/LogoutAction.php">Sair</a></li>
                </ul>
            <?php }
        ?>	 

		<!--SideNav Content -->
		<ul class="sidenav" id="mobile-demo">
			<ul class="center-align"><h5>ChooseMe</h5></ul>
			<hr>
			<ul class="collapsible">
				<li>
                    <?php 
                        //Verifica se está logado para exibir de forma correta
                        if(isset($_GET["notLogged"])){ ?>
                            <li><a class="black-text" href="login.php"><i class="material-icons">meeting_room</i>Acessar conta</a></li>
                            <li><a class="black-text" href="register.php"><i class="material-icons">create</i>Registre-se</a></li>
                        <?php }
                        //Se estiver logado carrega os dados do perfil
                        else{ ?>
                            <!-- Collapasible Header -->
                            <div class="collapsible-header">	
                                <i class="material-icons left">account_circle</i>	              	
                                    Olá <?php echo $firstName[0]; ?>!
                                <i class="material-icons right">arrow_drop_down</i>
                            </div>

                            <!-- Collapasible body -->
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="myServices.php">Meus anúncios</a></li>
                                    <li><a href="editProfile.php">Meu perfil</a></li>
                                    <li><a href="Action/LogoutAction.php">Sair</a></li>
                                </ul>
                            </div>
                        <?php }
                    ?>                    
				</li>
			</ul>
		</ul>

		<!-- Content --> 
		<div class="row container">
			<div class="col l8 s12">
                <h5>
                    <?php echo $service["title"] ?>
                </h5>

                <span class="grey-text">
                    <?php echo "Criado em: ". $date->format('d/m/y') ." às ". $date->format('H:i'); ?>
                </span>	
                
                <blockquote>
                    <textarea name="" id="" class="materialize-textarea" readonly><?php echo $service["description"]; ?></textarea>
                </blockquote>
                <button class="btn-small red accent-4 waves-effect waves-light"><i class="material-icons left">star_rate</i>Favoritar</button>
                <button class="btn-small red accent-4 waves-effect waves-light"><i class="material-icons left">share</i>Compartilhar</button>            
            </div>
            <br>

            <div class="col l3 s12 push-l1 center-align z-depth-2 grey lighten-5">
                <h5 class="center-align">
                    <?php echo $serviceUser["name"] ?>
                </h5>
                <div class="center-align">
                    <button class="btn-small red accent-4 waves-effect waves-light">Combinar horários</button>
                </div>
                <hr>
                <div class="center-align">
                    <p><a class="black-text waves-effect waves-red" href=""><i class="material-icons left">zoom_in</i> Visualizar anúncios</a></p>    
                </div>        
            </div>
        </div>

        <div class="row container">
            <h5>Detalhes do anúncio</h5>
            <div class="col s12">
                <p>Tipo: <?php echo $serviceDescription ?></p>
                <p>CEP: <?php echo $service["cep"] ?></p>
                <p>Cidade: <?php echo $service["city"] ?></p>
                <p>Estado: <?php echo $service["state"] ?></p>
            </div>            
        </div>
        

		<!-- Footer -->
		<footer class="page-footer red accent-4">
			<div class="footer-copyright red accent-4 white-text">
				<div class="container center-align">
					Powered By Waber Jr.
				</div>
			</div>
		</footer>
		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script>
			$(document).ready(function(){
				//NavBar Dropdown
				$(".dropdown-trigger").dropdown({
					coverTrigger: false,
				});

				//Collapsible
				$('.collapsible').collapsible();    

				//SideNav
				$('.sidenav').sidenav();   			
			});
		</script>
	</body>
</html>