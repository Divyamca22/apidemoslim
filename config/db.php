<?php 
class DB{
    private $host='localhost';
    private $user='root';
    private $pass='divyatnqse3';
    private $dbname='slim_api';

    public function connect(){
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str,$this->user,$this->pass);
        //$conn->setAttribute(PDO::ATTR_ERRMODE,PD0::ERRMODE_EXCEPTION);

        return $conn;
    }
}


?>