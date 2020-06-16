<?php 
	//Chamando as classes para enviar o Email
	require_once "../PHPMailer-master/src/PHPMailer.php";
	require_once "../PHPMailer-master/src/SMTP.php";
	require_once "../PHPMailer-master/src/Exception.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Enviar Email de verificação
	function sendEmail($email, $vKey){
		$mail = new PHPMailer(true);

		try {
			$mail->SMTP = SMTP::DEBUG_SERVER;
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = "easyofficeverificator@gmail.com";
			$mail->Password = "easyoffice3589";
			$mail->Port = 587;
			$mail->CharSet = "UTF-8";


			$mail->setFrom("easyofficeverificator@gmail.com");
			$mail->addAddress($email);

			$mail->isHTML(true);
			$mail->Subject = "E-mail de verificação Easy Office";
			$mail->Body = "Para verificar a sua conta, por favor <a href='http://localhost/chooseme/emailVerification.php?vkey=$vKey'>clique aqui</a>";
			$mail->AltBody = "O seu provedor não aceita links HTML";

			if($mail->send()){
				header("Location: ../thankYou.php");
			}
			else{
				echo "E-mail não enviado";
			}				
		} 
		catch (Exception $e) {
			echo "Erro ao enviar mensagem: $mail->ErrorInfo";
		}
	}	
?>
