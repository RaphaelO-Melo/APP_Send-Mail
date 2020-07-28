<?php

    //Importações customizadas
    require 'classes/Mensagem.php';
    //Importações PHPMailer
    require '../assets/PHPMailer-6.0/src/Exception.php';
    require '../assets/PHPMailer-6.0/src/OAuth.php';
    require '../assets/PHPMailer-6.0/src/PHPMailer.php';
    require '../assets/PHPMailer-6.0/src/POP3.php';
    require '../assets/PHPMailer-6.0/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mensagem = new Mensagem();
    
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //print_r($mensagem); 
    if($mensagem->mensagemValida())
        enviaEmail($mensagem);
    else
        echo 'Mensagem inválida';


    function enviaEmail($mensagem){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com';                   // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'raphael989898@outlook.com';        // SMTP username
            $mail->Password = 'senha1234@';                       // SMTP password
            $mail->SMTPSecure = 'STARTTLS';                       // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('raphael989898@outlook.com', 'Web Completo - Remetente');
            $mail->addAddress($mensagem->__get('para'));     // Add a recipient
            //$mail->addReplyTo('raphael989898@outlook.com', 'Web Completo - Destinatário para resposta');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $mensagem->__get('assunto');
            $mail->Body    = $mensagem->__get('mensagem');
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Messagem enviada com sucesso';
        } catch (Exception $e) {
            echo 'Não foi possível enviar este email. Tente novamente mais tarde.';
            echo 'Detalhes do erro: ' . $mail->ErrorInfo;
        }
    }
?>