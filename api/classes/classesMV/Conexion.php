<?php

/* 
 * @autor: Enrique Erick Gutiérrez Rojas
 */


require_once "../config/config.php";

class Conexion
{
    protected $_db;

    public function __construct()
    {
        $this->_db = mysql_connect(DB_HOST, DB_USER, DB_PASS)
		or die('No se pudo conectar: ' . mysql_error());;
	mysql_select_db(DB_NAME, $this->_db) or die('No se pudo seleccionar la base de datos');        	       
    }
    public function cierraConexion(){
       mysql_close($this->_db);     
    }
}
?> 