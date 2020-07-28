<?php

    Class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = ['codigo_status' => null, 'descricao_status' => null]; 

        public function __get($name){
            return $this->$name;
        }

        public function __set($name, $value){
            $this->$name = $value;
        }

        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem))
                return false;
            else
                return true;
        }
    }

?>