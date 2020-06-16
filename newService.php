<?php 
    require_once "Classes/UserDao.php";
    require_once "Classes/ServicesTypesDao.php";
	session_start();

	//Verificar se existe login
	if(!isset($_SESSION["logged"])){
		header("Location: home.php");
	}

	$userInfos = $_SESSION["userInfos"];
    $firstName = explode(" ", $userInfos["name"]);
    
    $userDao = new UserDao();
    //Pegando o telefone da tabela phones
	$userPhone = $userDao->selectUserPhones($userInfos["id_user"]);
	//Pegando o endereço da tabela adress
    $userAddress = $userDao->selectUserAddress($userInfos["id_user"]);

    $servicesTypesDao = new ServicesTypesDao();
    //Pegando os tipos de anúncios
    $servicesTypes = $servicesTypesDao->selectServicesTypes();

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
        <div>
            <div>
                <h5 class="center-align ">Descreva o seu serviço</h5>
            </div>  


            <form id="newService" action="Action/newServiceAction.php" method="POST">
                <div class="container z-depth-1">                
                    <br>
                    
                    <div class="row">
                        <div class="input-field col s12">
                            <input placeholder="" 
                                id="title"  
                                name="title" 
                                type="text" 
                                class="validate" 
                                minLength="5"
                                value="<?php echo isset($_SESSION["errorNewService"]) ? $_SESSION["errorNewService"]["title"] : "" ?>" 
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
                                    required><?php echo isset($_SESSION["errorNewService"]) ? $_SESSION["errorNewService"]["description"] : "" ?></textarea>
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
                                                <input name="type" checked value="<?php echo $type["id_service_type"] ?>" type="radio"/>
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
                                    value=" <?php 
                                        if($_SESSION["addressNotFound"] == false){
                                            echo $userAddress["0"]["cep"];
                                        } 
                                        else{
                                            if(isset($_SESSION["errorNewService"])){
                                                echo $_SESSION["errorNewService"]["cep"];
                                            }
                                            else{
                                                echo "";
                                            }
                                        }
                                    ?>"
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
                                    value=" <?php 
                                        if(isset($_SESSION["errorNewService"])){
                                            echo $_SESSION["errorNewService"]["neighborhood"];
                                        }
                                        else{
                                            if($_SESSION["addressNotFound"] == false){
                                                echo $userAddress["0"]["neighborhood"];
                                            }
                                            else{
                                                echo "";
                                            }
                                        }
                                    ?>"                                                                     
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
                                        value=" <?php 
                                            if(isset($_SESSION["errorNewService"])){
                                                echo $_SESSION["errorNewService"]["state"];
                                            }
                                            else{
                                                if($_SESSION["addressNotFound"] == false){
                                                    echo $userAddress["0"]["state"];
                                                }
                                                else{
                                                    echo "";
                                                }
                                            }
                                        ?>"                                        
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
                                        value=" <?php 
                                            if(isset($_SESSION["errorNewService"])){
                                                echo $_SESSION["errorNewService"]["city"];
                                            }
                                            else{
                                                if($_SESSION["addressNotFound"] == false){
                                                    echo $userAddress["0"]["city"];
                                                }
                                                else{
                                                    echo "";
                                                }
                                            }
                                        ?>"
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
                                value=" <?php 
                                    if(isset($_SESSION["errorNewService"])){
                                        echo $_SESSION["errorNewService"]["neighborhood"];
                                    }
                                    else{
                                        if($_SESSION["addressNotFound"] == false){
                                            echo $userAddress["0"]["neighborhood"];
                                        }
                                        else{
                                            echo "";
                                        }
                                    }
                                ?>"
                            >
                    </div>	

                    <div class="col s3 push-s3">
                        <input  placeholder="" 
                                id="state"
                                name="state" 
                                type="hidden" 
                                class="validate"                                    
                                value=" <?php 
                                    if(isset($_SESSION["errorNewService"])){
                                        echo $_SESSION["errorNewService"]["state"];
                                    }
                                    else{
                                        if($_SESSION["addressNotFound"] == false){
                                            echo $userAddress["0"]["state"];
                                        }
                                        else{
                                            echo "";
                                        }
                                    }
                                ?> "
                            >
                    </div>

                    <div class="col s3 push-s3">										
                        <input  placeholder="" 
                                id="city"
                                name="city" 
                                type="hidden" 
                                class="validate"                                    
                                value=" <?php 
                                    if(isset($_SESSION["errorNewService"])){
                                        echo $_SESSION["errorNewService"]["city"];
                                    }
                                    else{
                                        if($_SESSION["addressNotFound"] == false){
                                            echo $userAddress["0"]["city"];
                                        }
                                        else{
                                            echo "";
                                        }
                                    }
                                ?>"
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
                                    value=" <?php  
                                        if(isset($_SESSION["errorNewService"])){
                                            echo $_SESSION["errorNewService"]["phone"];
                                        }
                                        else{
                                            if($_SESSION["phoneNotFound"] == false){
                                                echo $userPhone["0"]["phone"];
                                            }
                                            else{
                                                echo "";
                                            }
                                        }
                                    ?>" 
                                >
                            <label for="phone">Telefone</label>
                        </div>
                        <div class="center-align col s12">
                            <p >
                                <label>
                                    <input  type="checkbox" 
                                            name="hidePhone" 
                                            value="1" 
                                            <?php if(!isset($_SESSION["errorNewService"])){
                                                    echo "checked";
                                                }
                                                else{
                                                    if($_SESSION["errorNewService"]["hidePhone"] == "1"){
                                                        echo "checked";
                                                    }
                                                    else{
                                                        echo "";
                                                    }
                                                }
                                            ?> 
                                            />
                                    <span>Ocultar meu telefone neste anúncio</span>
                                </label>
                            </p>
                        </div>
                    </div>                               
                </div>
                <div class="center-align">
                    <button type="submit" name="btnNewService" class="btn-small red accent-4 waves-effect waves-light">Enviar anúncio!</button>
                </div>
            </form>        
        </div>
        
        <br>

        <!-- Footer -->
        <footer class="page-footer red accent-4">
            <div class="footer-copyright red accent-4 white-text">
                <div class="container center-align">
                    Powered By Waber Jr.
                </div>
            </div>
        </footer>
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>	
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
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

            $(document).ready(function(){
                //NavBar Dropdown
                $(".dropdown-trigger").dropdown({
                    coverTrigger: false,
                });

                //Collapsible
                $('.collapsible').collapsible();    

                //SideNav
                $('.sidenav').sidenav(); 
                
                $("#cep").mask("00000-000");

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //Busca CEP	
                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
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
                            $("#neighborhood").val("...");
                            $("#city").val("...");
                            $("#state").val("...");

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#neighborhood").val(dados.bairro);
                                    $("#neighborhoodDisabled").val(dados.bairro);
                                    $("#city").val(dados.localidade);
                                    $("#cityDisabled").val(dados.localidade);
                                    $("#state").val(dados.uf);
                                    $("#stateDisabled").val(dados.uf);
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
            if(isset($_SESSION["newServiceMessage"])){ ?>
                <script>
                    M.toast({html: '<?php echo $_SESSION["newServiceMessage"] ?>'})
                </script>		
            <?php }
            unset($_SESSION["newServiceMessage"]);
            unset($_SESSION["errorNewService"]);
        ?>
    </body>
</html>