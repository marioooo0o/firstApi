<?php
class Database
{
    //pola składowe bazy danych
    private $host = "localhost";
    private $db_name = "first_api";
    private $username = "root";
    private $password = "";
    public $conn;

    //połączenie z bazą danych
    public function getConnection()
    {
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch (PDOException $expception){
            echo "Connection error: " .$expception->getMessage();
        }
        return $this->conn;
    }
}
?>