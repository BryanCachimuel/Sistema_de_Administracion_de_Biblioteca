<?php

class MySQLdb {
    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $db = "biblioteca";
    private $puerto = "";
    private $conn;

    function __construct() {
        try {
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db, 
            $this->usuario,
            $this->clave
        );
        //echo "Conectado";
        } catch (Exception $e) {
            die("No se pudo conectar: " . $e->getMessage());
        }
    }

    public function query($sql=''){
        if(empty($sql)) return false;
        $stmt = $this->conn->query($sql);
        return $stmt->fetch();
    }

    // Update, Delete, Insert => para regresar un true o false
    public function queryNoSelect($sql, $data) {
        return $this->conn->prepare($sql)->execute($data);
    }

}