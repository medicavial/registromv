<?php
/* 
 @autor: Enrique Erick Gutiérrez Rojas
 */

require_once "Conexion.php";

class Usuarios extends Conexion
{    
    public function __construct()
    {
        parent::__construct();
    }

    public function get_users($usuarioLogin)
    {
 	$query = "SELECT * FROM Usuario WHERE Usu_login ='".$usuarioLogin."'";
        $result = mysql_query($query);	
        $users = mysql_fetch_array($result,MYSQL_ASSOC);
        parent::cierraConexion();
         if( $users ) return $users;
         else return 'fail';
    }

    public function consultaDatos($query){
        $result = mysql_query($query);  
        //$users = mysql_fetch_array($result);
        $valores = array();
        $i = 0;
        while ($resEmp = mysql_fetch_assoc($result)) {
            $valores[$i] = $resEmp;
            $i++;
        }       
        parent::cierraConexion();
         if( $valores ) return $valores;
         else return 'fail';   
    }
}
