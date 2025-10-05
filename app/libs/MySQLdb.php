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

    public function querySelect($sql='') {
		if (empty($sql)) return false;
		$data = [];
		$stmt = $this->conn->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		   do {
		       array_push($data,$row);
		   } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
		if (!$data[0]) {
			$data = [];
		}
		return $data;
	}

    // Update, Delete, Insert => para regresar un true o false
    public function queryNoSelect($sql,$data="")
	{
		if ($data=="") {
			return $this->conn->query($sql);
		} else {
			return $this->conn->prepare($sql)->execute($data);
		}
	}

    public function queryCrudo($sql="") {
        return $this->conn->query($sql);
    }

    public function getBaseDatos() {
        return $this->db;
    }
}