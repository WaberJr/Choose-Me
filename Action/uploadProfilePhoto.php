<?php 
	//Fazer o upload da foto de perfil
	if(isset($_POST['sendProfilePhoto'])){
		$formats = [".png", ".jpeg", ".jpg"]; //Formatos permitidos
		$extension = strtolower(substr($_FILES["profilePhoto"]["name"], -4)); //Pega a extensão		

		if(in_array($extension, $formats)){
			$newName = md5(time()) . $extension; //Define o nome do arquivo
			$directory = "../profilePhotos/"; //Diretório

			if(move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], $directory.$newName)){
				
			}
			else{
				$_SESSION["uploadMessage"] = "Não foi possível fazer o upload";
			}
		}
		else{
			$_SESSION["uploadMessage"] = "formato inválido";
		}
		header("Location: ../home.php");
	}
?>