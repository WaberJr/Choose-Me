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

    
    $servicesDao = new ServicesDao();
    //Busca pelo termo de pesquisa
    if(isset($_GET["search"])){
        $search = $_GET["search"];
        $searches = $servicesDao->selectAllServicesWhere($search);
    }

    //Busca pela UF
    if(isset($_GET["uf"])){
        $uf = $_GET["uf"];
        $searches = $servicesDao->selectServiceByUf($uf); 
    }

	$servicesTypesDao = new ServicesTypesDao();
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
            <div class="col s12">
                <h5><i class="material-icons">local_offer</i> Resultados da busca:</h5>		
            </div>								
			<div class="col s7">                
				<div class="collection">
				<?php 
					if(!isset($_SESSION["serviceNotFound"])){
						foreach($searches as $service){ 
							$date = new DateTime($service["createData"]);	
							?>	
							<a href="<?php echo "visualizeService.php?id_service=". $service["id_service"] . "&identifier=" . $service["identifier"] ."&notLogged=1"?>" class="collection-item black-text"> 
								<!-- Título -->
								<h5 class="truncate"><?php echo $service["title"] ?></h5> 
								<br>
								<!-- Cidade/Estado -->
								<?php
								echo $service["city"] ." / ". $service["state"];
								?>	
								<br>
								<!-- Descrição do tipo -->
								<?php
								$typeDescription = $servicesTypesDao->selectServicesTypesById($service["type"]); 
								$typeDescription = $typeDescription[0]["description"];
								echo $typeDescription;
								?>
														
								<!--Exibe apenas para telas maiores -->
								<span class="badge hide-on-med-and-down">
									<?php echo "Criado em: ". $date->format('d/m/y') ." às ". $date->format('H:i'); ?>
								</span>		
					
							</a>
							<?php }
						} 
						else{ ?>
							<div class="center-align">
								<h5><?php echo $_SESSION["serviceNotFound"] ?></h5>
								<p> Não perca tempo e faça o seu primeiro anúncio.</p>	
								<p><a href="newService.php" class="btn red accent-4 waves-effect waves-light white-text">Crie um anúncio agora!</a></p>					
							</div>
						<?php }
					?>
                </div>                
            </div>                        
            <div class="col s4">
                <div class="nav-wrapper z-depth-1">
                    <form action="search.php?search=<?php echo  $_GET["search"] ?>" name="searchForm" id="searchForm" method="GET">
                        <div class="input-field">
                            <input id="search" name="search" type="search" placeholder="Busque por serviços">
                            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
                </div>
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