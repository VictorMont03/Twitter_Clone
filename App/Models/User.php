<?php
    namespace App\Models;

    use MF\Model\Model;

    class User extends Model{
        private $id;
        private $nome;
        private $email;
        private $senha;

        public function __get($attr){
            return $this->$attr;
        }

        public function __set($attr, $value){
            $this->$attr = $value;
        }

        public function create(){
            $query = "insert into usuarios(nome, email, senha) values(:nome, :email, :senha)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha')); //md-5() hash 32 caracteres

            $stmt->execute();

            return $this;
        }

        public function getUserPorEmail(){
            $query = "select nome, email from usuarios where email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function validate(){
            $valido = true;

            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) { //valida endereços de e-mail em relação à addr-specsintaxe em »RFC 822
               // echo("is a valid email address");
            } else {
               // echo("is not a valid email address");
                $valido = false;
            }

            if(strlen($this->__get('senha')) < 5){
                $valido = false;
            }

            if(strlen($this->__get('nome')) < 3){
                $valido = false;
            }

            return $valido;
        }

        public function autenticar(){
            $query = 'select id, nome, email from usuarios where senha = :senha and email = :email';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue('email', $this->__get('email'));
            $stmt->bindValue('senha', $this->__get('senha'));

            $stmt->execute();

            $retorno = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            //print_r($retorno);

            if($retorno[0]['id'] != '' && $retorno[0]['nome'] != ''){
                $this->__set('nome', $retorno[0]['nome']);
                $this->__set('id', $retorno[0]['id']);
                return $this;
            }else{
                return;
            }
        }

    }
?>