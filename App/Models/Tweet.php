<?php
    namespace App\Models;

    use MF\Model\Model;

    class Tweet extends Model{
        private $id;
        private $id_usuario;
        private $tweet;
        private $date;

        public function __get($attr){
            return $this->$attr;
        }

        public function __set($attr, $value){
            $this->$attr = $value;
        }

        public function create(){
            $query = 'insert into tweets(id_usuario, tweet) values(:id_usuario, :tweet)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
            $stmt->bindValue(':tweet',$this->__get('tweet'));

            $stmt->execute();

            return $this;
        }

        public function read(){
            $query = 'select 
                        t.id, t.tweet, t.id_usuario, DATE_FORMAT(t.date, "%d/%m/%Y %H:%i") as date, u.nome
                    from 
                        tweets as t
                    left join usuarios as u on (t.id_usuario = u.id)
                    order by
                        t.date desc
                    ';
            $stmt = $this->db->prepare($query);
            //$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }


    }
?>