<?php
    class DB{
        public $connection = null;
        function __construct($host, $name, $user, $pass){
            $this -> connection = new mysqli($host, $user, $pass, $name);
            if ($this -> connection -> connect_errno){
                $this -> connection = false;
            }
        }
        public function query($str){
            $res = $this -> connection -> query($str);
            try{
                $res -> data_seek(0);
            } catch(Error $e){
                return $res;
            }
            $ret = [];
            while ($row = $res -> fetch_assoc()) {
                $ret[] = $row;
            }
            return $ret;
        }
    }
?>