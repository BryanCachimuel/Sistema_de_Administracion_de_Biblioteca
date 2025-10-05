<?php

class TableroModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }
    
}
