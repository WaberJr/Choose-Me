<?php 
	session_start();
	require_once "Classes/ServicesDao.php";
    require_once "Classes/ServicesTypesDao.php";
    $accessNotAllowed= false;

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
		header("Location: home.php");
    }

	$userInfos = $_SESSION["userInfos"];
	$firstName = explode(" ", $userInfos["name"]);

	$id_service = $_GET["id_service"];

	//Buscando os dados do anúncio
	$servicesDao = new ServicesDao();
	$service = $servicesDao->selectService($id_service, $userInfos["id_user"]);
    //Se tiver valor na busca ele atribui ao index 0
    if($service){
        $service = $service["0"];
    }
    
	//Pegando os tipos de anúncios
	$servicesTypesDao = new ServicesTypesDao();    
    $servicesTypes = $servicesTypesDao->selectServicesTypes();   
    
    //Verificando se quem está acessando o link é o usuário logado
    if($_GET["id_user"] != $userInfos["id_user"]){
        $accessNotAllowed= true;
    }
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
					<li>	        		
						<a class="dropdown-trigger hide-on-med-and-down" data-target="dropdown1" data-beloworigin="true">	
							<i class="material-icons left">account_circle</i>	              	
							Olá <?php echo $firstName[0]; ?>!
							<i class="material-icons right">arrow_drop_down</i>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<!--NavBar DropDown Content -->
		<ul id="dropdown1" class="dropdown-content">
			<!-- Modal Trigger -->
			<li><a href="myServices.php">Meus anúncios</a></li>
			<li><a href="editProfile.php">Meu perfil</a></li>
			<li><a href="Action/LogoutAction.php">Sair</a></li>
		</ul>

		<!--SideNav Content -->
		<ul class="sidenav" id="mobile-demo">
			<ul class="center-align"><h5>Easy Office</h5></ul>
			<hr>
			<ul class="collapsible">
				<li>
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
				</li>
			</ul>
		</ul>

		<!-- Content --> 
        <?php 
            if(!$accessNotAllowed){ ?>
                <div>
                    <div class="row">
                        <div>
                            <div>
                                <h5 class="center-align ">Editar Anúncio</h5>
                            </div>  


                            <form id="newService" action="Action/editServiceAction.php" method="POST">	
                                <div class="container z-depth-1">                
                                    <br>

                                    <div class="center-align">
                                        <!-- Modal Trigger -->
                                        <a class="btn-small red accent-4 waves-effect waves-light modal-trigger" href="#deleteServiceModal"><i class="material-icons">delete_outline</i></a>
                                        <button type="submit" name="btnEditService" class="btn-small red accent-4 waves-effect waves-light">Salvar</button>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="" 
                                                id="title"  
                                                name="title" 
                                                type="text" 
                                                class="validate" 
                                                minLength="5"
                                                value="<?php echo $service["title"]; ?>" 
                                                required>
                                            <label for="title">Título*</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea placeholder="" 
                                                    id="description" 
                                                    name="description" 
                                                    class="materialize-textarea validate" 
                                                    minLength="10"
                                                    required><?php echo $service["description"]; ?></textarea>
                                            <label for="description">Descrição*</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s12">
                                            <p class="center-align">Tipo</p>
                                            <div class="container">
                                                <?php 
                                                    foreach($servicesTypes as $type){ ?>
                                                        <p>
                                                            <label>
                                                                <input  name="type" 
                                                                        value="<?php echo $type["id_service_type"] ?>" 
                                                                        <?php echo $service["type"] == $type["id_service_type"] ? "checked" : ""?>
                                                                        type="radio"/>
                                                                <span><?php echo $type["description"] ?></span>
                                                            </label>
                                                        </p>
                                                    <?php }  
                                                ?>                                                                         
                                            </div> 
                                        </div>
                                                        
                                    </div>

                                    <p class="center-align">Preencha o CEP</p>
                                    
                                    <div class="row">
                                        <div class="input-field col s6 push-s3">
                                            <input  placeholder="" 
                                                    name="cep" 
                                                    id="cep"
                                                    type="text" 
                                                    class="validate" 
                                                    minLength="9"
                                                    required
                                                    value="<?php echo $service["cep"]; ?>"
                                                >
                                            <label for="cep">CEP*</label>
                                        </div>
                                    </div>

                                    <!--Disabled-->
                                    <div class="row">
                                        <div class="input-field col s6 push-s3">
                                            <input  placeholder="" 
                                                    id="neighborhoodDisabled" 
                                                    type="text" 
                                                    disabled   
                                                    value="<?php echo $service["neighborhood"]; ?>"                                                                     
                                                >
                                            <label for="neighborhood">Bairro</label>
                                        </div>
                                    </div>	

                                    <div class="row">
                                        <div class="col s3 push-s3">
                                            <div class="input-field">
                                                <input  placeholder="" 
                                                        id="stateDisabled" 
                                                        type="text" 
                                                        disabled
                                                        value="<?php echo $service["state"]; ?> "                                        
                                                    >
                                                <label for="state">UF</label>
                                            </div>
                                        </div>

                                        <div class="col s3 push-s3">										
                                            <div class="input-field">
                                                <input  placeholder="" 
                                                        id="cityDisabled" 
                                                        type="text" 
                                                        disabled
                                                        value="<?php echo $service["city"]; ?>"
                                                    >
                                                <label for="city">Cidade</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Hidden-->
                                    <div class="row">
                                        <input  placeholder="" 
                                                id="neighborhood"
                                                name="neighborhood" 
                                                type="hidden" 
                                                class="validate"                                
                                                value="<?php echo $service["neighborhood"]; ?>"
                                            >
                                    </div>	

                                    <div class="row">
                                        <input  placeholder="" 
                                                id="state"
                                                name="state" 
                                                type="hidden" 
                                                class="validate"                                    
                                                value=" <?php echo $service["state"]; ?> "
                                            >
                                    </div>

                                    <div class="row">										
                                        <input  placeholder="" 
                                                id="city"
                                                name="city" 
                                                type="hidden" 
                                                class="validate"                                    
                                                value="<?php echo $service["city"]; ?>"
                                            >
                                    </div>

                                    <p class="center-align">Contato</p>

                                    <div class="row">		      																
                                        <!--Phone-->
                                        <div class="input-field col s6 push-s3">
                                            <input  placeholder="" 
                                                    name="phone" 
                                                    id="phone" 
                                                    type="text" 
                                                    maxLength="15"
                                                    required
                                                    value="<?php echo $service["phone"]; ?>" 
                                                >
                                            <label for="phone">Telefone</label>
                                        </div>
                                        <div class="center-align col s12">
                                            <p>
                                                <label>
                                                    <input  type="checkbox" 
                                                            name="hidePhone" 
                                                            value="1" 
                                                            <?php echo $service["hidePhone"] == "1" ? "checked" : ""?> 
                                                            />
                                                    <span>Ocultar meu telefone neste anúncio</span>
                                                </label>
                                            </p>
                                        </div>
                                    </div>                               
                                </div>  
                                <input type="hidden" name="id_service" value=" <?php echo $service["id_service"]; ?>">  
                                <input type="hidden" name="id_user" value=" <?php echo $userInfos["id_user"]; ?>">               
                            </form>        
                        </div>	
                    </div>
                </div>
            <?php } 
            else{ ?>
                <!-- Content -->
                <div class="row container center-align vertical">
                    <div class="col s12 light">
                        <h5>Acesso negado!</h5>
                        <h5>Você está tentando acessa um conteúdo onde não tem permissão. Por favor, volte para o início.</h5>
                    </div>

                    <div class="col s12">
                        <i class="material-icons large">report_problem</i>
                    </div>

                    <div class="col s12">
                        <button class="btn red accent-4 waves-effect waves-light "><a href="index.php" class="white-text">Voltar para o início</a></button>
                    </div>
                </div>
            <?php }
        ?>
		  

		<!-- Footer -->
		<footer class="page-footer red accent-4">
			<div class="footer-copyright red accent-4 white-text">
				<div class="container center-align">
					Powered By Waber Jr.
				</div>
			</div>
		</footer>

		<!-- Modal Structure -->
		<div id="deleteServiceModal" class="modal">
			<div class="modal-content">
				<h4>Atenção</h4>
				<p>Tem certeza que deseja excluir este anúncio?</p>
			</div>
			<div class="modal-footer">               
				<a class="btn-small red accent-4 waves-effect waves-light modal-close">Cancelar</a>          
                <a href="Action/deleteServiceAction.php?id_service=<?php echo $id_service ?>" class="btn-flat waves-effect waves-light">Sim, eu quero</a>     
			</div>
		</div>
		
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

				//Modal
				$('.modal').modal();			
            });
            
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //Busca CEP	
			$(document).ready(function() {
				function limpa_formulário_cep() {
					// Limpa valores do formulário de cep.
					$("#street").val("");
					$("#neighborhood").val("");
					$("#city").val("");
					$("#state").val("");
				}

				//Quando o campo cep perde o foco.
				$("#cep").blur(function() {

					//Nova variável "cep" somente com dígitos.
					var cep = $(this).val().replace(/\D/g, '');

					//Verifica se campo cep possui valor informado.
					if (cep != "") {

						//Expressão regular para validar o CEP.
						var validacep = /^[0-9]{8}$/;

						//Valida o formato do CEP.
						if(validacep.test(cep)) {

							//Preenche os campos com "..." enquanto consulta webservice.
							$("#street").val("...");
							$("#neighborhood").val("...");
							$("#city").val("...");
							$("#state").val("...");

							//Consulta o webservice viacep.com.br/
							$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

								if (!("erro" in dados)) {
									//Atualiza os campos com os valores da consulta.
									$("#street").val(dados.logradouro);
									$("#neighborhood").val(dados.bairro);
									$("#city").val(dados.localidade);
									$("#state").val(dados.uf);
								} //end if.
								else {
									//CEP pesquisado não foi encontrado.
									limpa_formulário_cep();
									alert("CEP não encontrado.");						
								}
							});
						} //end if.
						else {
							//cep é inválido.
							limpa_formulário_cep();
							alert("Formato de CEP inválido.");
						}
					} //end if.
					else {
						//cep sem valor, limpa formulário.
						limpa_formulário_cep();
					}
				});
			});
		</script>
        <?php
			if(isset($_SESSION["editServiceMessage"])){ ?>
				<script>
					M.toast({html: '<?php echo $_SESSION["editServiceMessage"] ?>'})
				</script>		
			<?php }
			unset($_SESSION["editServiceMessage"]);
		?>
	</body>
</html>