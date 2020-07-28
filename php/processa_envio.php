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
        header('Location: ../index.php');


    function enviaEmail($mensagem){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = false;                             // Enable verbose debug output
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
            $mensagem->status['codigo_status'] = 1;
            $mensagem->status['descricao_status'] = 'Messagem enviada com sucesso';

        } catch (Exception $e) {
            $mensagem->status['codigo_status'] = 2;
            $mensagem->status['descricao_status'] = 'Não foi possível enviar este email. Tente novamente mais tarde. ' . 'Detalhes do erro: ' . $mail->ErrorInfo;
        }
    }
?>

<html>

    <head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>

    <body>
        
        <div class="container">

        <div class="py-3 text-center">
			<img class="d-block mx-auto mb-2" src="../assets/images/logo.png" alt="" width="72" height="72">
			<h2>Send Mail</h2>
			<p class="lead">Seu app de envio de e-mails particular!</p>
        </div>
        
        <div class="row">
            <div class="col-md-12">


            <?php if($mensagem->status['codigo_status'] == 1){ ?>

                <div class="container">
                    <h1 class="display-4 text-success">
                        Sucesso!
                    </h1>
                    <p>
                        <?php echo $mensagem->status['descricao_status'] ?>
                    </p>

                    <a href="../index.php" class="btn btn-success btn-lg mb-5 text-white">Voltar</a>
                </div>

            <?php } ?>

            <?php if($mensagem->status['codigo_status'] == 2){ ?>

                <div class="container">
                    <h1 class="display-4 text-danger">
                        Ops!
                    </h1>
                    <p>
                        <?php echo $mensagem->status['descricao_status'] ?>
                    </p>

                    <a href="../index.php" class="btn btn-success btn-lg mb-5 text-white">Voltar</a>
                </div>
            
            <?php } ?>

            </div>
        </div>

        </div>

    </body>
</html>