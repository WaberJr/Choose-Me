<?php 
	require_once "Classes/UserDao.php";
	session_start();	

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
		header("Location: home.php");
	}

	$userDao = new UserDao();
	
	//Selecionando todos os dados pelo id do usuário 
	$userInfos = $userDao->selectUserById($_SESSION["userInfos"]["id_user"]);
	$userInfos = $userInfos[0];
	//Pegando o primeiro nome
	$firstName = explode(" ", $userInfos["name"]);
	//Pegando o telefone da tabela phones
	$userPhone = $userDao->selectUserPhones($userInfos["id_user"]);
	//Pegando o endereço da tabela adress
	$userAddress = $userDao->selectUserAddress($userInfos["id_user"]);
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
		<div class="container">
			<form action="Action/editProfileAction.php" method="POST">
				<div class="row">
					<div class="col s6">
						<h4>Editar perfil</h4>
					</div>

					<div class="col s6">
						<br>
						<button type="submit" name="btnLogin" class="btn right btn red accent-4 waves-effect waves-light">Salvar</button>
					</div>
					
					<div class="col s12">
						<hr>
					</div>

					<h5 class="col s-6 left">Foto</h5>	
					<br>	

					<div class="file-field col s-6 right">
						<input type="file" id="profileImg">Editar foto</input>	
					</div>
				</div>	   

			
				<div class="row">
					<div class="col s2 push-s5">
						<img class="responsive-img circle" id="img" src="images/accountCircle.png">	
					</div>		      	
				</div>

				<!-- Tabs -->
				<div class="row ">
					<!-- Tab Header -->
					<ul class="tabs tabs-fixed-width z-depth-1">
						<li class="tab"><a class="active black-text" href="#personalInfo">Info. pessoais</a></li>
						<li class="tab"><a class="black-text" href="#documentation">Documentação</a></li>
					</ul>
					<br>
					<!-- Tab content -->
					<!-- Info. Pessoais -->
					<div id="personalInfo" class="col s12">
						<div class="col s12">
							<div class="row">
								<div class="input-field col s12">
									<!--Name-->
									<input placeholder="" name="name" type="text" minlength="4" value="<?php echo $userInfos["name"] ?>" required class="validate">
									<label for="name">Nome</label>
								</div>				        	
							</div>
							
							<p class="center-align">Contato</p>

							<!--Phones-->
							<div>
								<div class="row">		      																
									<!--Phone-->
									<div class="input-field col s6 push-s3">
										<input  placeholder="" 
												name="phone" 
												id="phone" 
												type="text" 
												maxLength="15"
												value="<?php echo $_SESSION["phoneNotFound"] == false ? $userPhone["0"]["phone"] : ""?>" 
												>
										<label for="phone">Telefone</label>
									</div>
								</div>
							</div>
							
							<p class="center-align">Endereço</p>

							<!--Address-->
							<div class="row">
								<div class="col s10 push-s1">
									<div class="row">      																
										<!--CEP-->
										<div class="input-field col s8 push-s2">
											<input  placeholder="" 
													name="cep" 
													id="cep"
													type="text" 
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["cep"] : ""?>"							          				
													>
											<label for="cep">CEP</label>
										</div>

									</div>
							
									<div class="row">
										<div class="col s7">
											<div class="input-field">
												<input placeholder="" 
													name="street" 
													id="street" 
													type="text" 
													class="validate"
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["street"] : ""?>"
													>
												<label for="street">Rua</label>
											</div>
										</div>

										<div class="col s5">
											<div class="input-field">
												<input placeholder="" 
													name="number" 
													id="number" 
													type="text" 
													class="validate"
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["number"] : ""?>"
													>
												<label for="number">Número</label>
											</div>
										</div>
									</div>	

									<div class="row">
										<div class="col s6">
											<div class="input-field">
												<input placeholder="" 
													name="complement" 
													id="complement" 
													type="text" 
													class="validate"
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["complement"] : ""?>"
													>
												<label for="complement">Complemento</label>
											</div>
										</div>

										<div class="col s6">
											<div class="input-field">
												<input placeholder="" 
													name="neighborhood" 
													id="neighborhood" 
													type="text" 
													class="validate"
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["neighborhood"] : ""?>"
													>
												<label for="neighborhood">Bairro</label>
											</div>
										</div>									
									</div>

									<div class="row">
										<div class="col s6">
											<div class="input-field">
												<input placeholder="" 
													name="state" 
													id="state" 
													type="text" 
													class="validate"
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["state"] : ""?>"
													>
												<label for="state">UF</label>
											</div>
										</div>

										<div class="col s6">										
											<div class="input-field">
												<input placeholder="" 
													name="city" 
													id="city" 
													type="text" 
													class="validate"
													value="<?php echo $_SESSION["addressNotFound"] == false ? $userAddress["0"]["city"] : ""?>"
													>
												<label for="city">Cidade</label>
											</div>
										</div>
									</div>
								</div>								
							</div>			   	
						</div>
					</div> 

					<!-- Documentação -->
					<div id="documentation" class="col s12">
						<div class="row">
							<div class="col s6">
								<div class="input-field">
									<input placeholder="" name="cpf" id="cpf" type="text" value="<?php echo $userInfos["cpf"] ?>" class="validate">
									<label for="cpf">CPF</label>
								</div>
							</div>

							<div class="col s6">
								<div class="input-field">
									<input placeholder="" name="rg" type="text" value="<?php echo $userInfos["rg"] ?>" class="validate">
									<label for="rg">RG</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>

		<!-- Footer -->
		<footer class="page-footer red accent-4">
			<div class="footer-copyright red accent-4">
				<div class="container center-align">
					Powered By Waber Jr.
				</div>
			</div>
		</footer>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="javascript/editProfile.js"></script>
		<script type="text/javascript">		
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


			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			// Faz com que a tecla enter tenha efeito de TAB pulando de campo em campo
			$(document).ready(function() {
				$('input').keypress(function(e) {
					var code = null;
					code = (e.keyCode ? e.keyCode : e.which);
					return (code === 13) ? false : true;		
				});
		
				$('input[type=text]').keydown(function(e) {
					// Obter o próximo índice do elemento de entrada de texto
					var next_idx = $('input[type=text]').index(this) + 1;
		
					// Obter o número de elemento de entrada de texto em um documento html
					var tot_idx = $('body').find('input[type=text]').length;
		
					// Entra na tecla no código ASCII
					if (e.keyCode === 13) {
						if (tot_idx === next_idx)
							// Vá para o primeiro elemento de texto
							$('input[type=text]:eq(0)').focus();
						else
							// Vá para o elemento de entrada de texto seguinte
							$('input[type=text]:eq(' + next_idx + ')').focus();
					}
				});
			});
			
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
			//Pre-visualization profile image
			$(function(){
				$("#profileImg").change(function(){
					const file = $(this)[0].files[0];
					const fileReader = new FileReader();

					fileReader.onloadend = function(){
						$("#img").attr("src", fileReader.result)
					}
					fileReader.readAsDataURL(file);
				})
			})

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			//Máscara de telefone
			function mascara(o,f){
				v_obj=o
				v_fun=f
				setTimeout("execmascara()",1)
			}
			function execmascara(){
				v_obj.value=v_fun(v_obj.value)
			}
			function mtel(v){
				v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
				v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
				v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
				return v;
			}
			function id( el ){
				return document.getElementById( el );
			}
			window.onload = function(){
				id('phone').onkeyup = function(){
					mascara( this, mtel );
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			//jquery
			$(document).ready(function(){    
				//NavBar Dropdown
				$(".dropdown-trigger").dropdown({
					coverTrigger: false,
				});

				//Collapsible
				$('.collapsible').collapsible();    

				//Tabs
				$('.tabs').tabs();

				//SideNav
				$('.sidenav').sidenav(); 

				//Select
				$('select').formSelect();		

				//Máscaras
				$("#cpf").mask("000.000.000-00");

				$("#cep").mask("00000-000");			
			});

		</script>
		<?php
			if(isset($_SESSION["editProfileMessage"])){ ?>
				<script>
					M.toast({html: '<?php echo $_SESSION["editProfileMessage"] ?>'})
				</script>		
			<?php }
			unset($_SESSION["editProfileMessage"]);
		?>
	</body>
</html>

