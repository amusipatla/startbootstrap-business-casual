<?php
 require_once ("class.phpmailer.php");
 $Correo = new PHPMailer();
 $Correo->IsSMTP();
 $Correo->SMTPAuth = true;
 $Correo->SMTPSecure = "tls";
 $Correo->Host = "smtp.gmail.com";
 $Correo->Port = 587;
 $Correo->Username = "techtreatsbakery@gmail.com";
 $Correo->Password = "techtreat";
 $Correo->SetFrom('techtreatsbakery@gmail.com','De Yo');
 $Correo->FromName = "From";
 $Correo->AddAddress("abdullah.shareef@gmail.com");
 $Correo->Subject = "Prueba con PHPMailer";
 $Correo->Body = "<H3>Bienvenido! Esto Funciona!</H3>";
 $Correo->IsHTML (true);
 if (!$Correo->Send())
 {
   echo "Error: $Correo->ErrorInfo";
 }
 else
 {
   echo "Message Sent!";
 }
?>
