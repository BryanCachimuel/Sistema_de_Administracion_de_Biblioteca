<?php

class ConsultarModelo {
    private $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }
}