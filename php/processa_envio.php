<?php

    //Importações
    include_once 'classes/Mensagem.php';
    
    $mensagem = new Mensagem();
    
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //print_r($mensagem); 
    if($mensagem->mensagemValida())
        echo 'Mensagem válida';
    else
        echo 'Mensagem inválida';
?>