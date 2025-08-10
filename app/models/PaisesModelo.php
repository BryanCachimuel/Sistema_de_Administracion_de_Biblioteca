<?php

class PaisesModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function alta($data='') {

    }

    public function bajaLogica($id='') {

    }

    public function getPaisId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM paises WHERE id='".$id."'";
		return $this->db->query($sql);
	}


   

}