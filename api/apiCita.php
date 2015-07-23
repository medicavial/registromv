<?php

include ('classes/nomad_mimemail.inc.php');

//tiempo de espera en caso de tardar mas de 30 segundos una consulta grande
set_time_limit(3600);
//sin limite me memoria 
ini_set('memory_limit', '-1');
//ocultar los errores
error_reporting(0);

date_default_timezone_set('America/Mexico_City'); //Ajustando zona horaria


function conectar(){

    $host="localhost";
    //$host="localhost";
    $user="medica_webusr";
    $password="tosnav50";
    $conn=mysql_connect($host,$user,$password) or die('Error al conectar: ' . mysql_error());
    mysql_select_db("medica_registromv",$conn);
    
	return $conn;
}


function generar_clave(){ 

    $pares = '24680';
    $nones = '13579';
    $vocales = 'AEIOU';
    $consonantes = "BCDEFGHIJKLMNOPQRSTUVWXYZ";
    $todos = $vocales . $pares . $consonantes . $nones;
    $valor = "";

    $valor .= substr($vocales,rand(0,4),1);
    $valor .= substr($consonantes,rand(0,23),1);
    $valor .= substr($pares,rand(0,4),1);
    $valor .= substr($nones,rand(0,4),1);
    $valor .= substr($todos,rand(0,34),1);

    return $valor;
} 

function conectarMySQL(){

    //$dbhost="www.medicavial.net";
    $dbhost="localhost";
    $dbuser="medica_webusr";
    $dbpass="tosnav50";
    $dbname="medica_registromv";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

//Obtenemos la funcion que necesitamos y yo tengo que mandar 
//la URL de la siguiente forma api/api.php?funcion=login

$funcion = $_REQUEST['funcion'];
$cliente = $_REQUEST['cliente'];


if($funcion == 'login'){
    
    //Obtenemos los datos que mandamos de angular
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    $conexion = conectarMySQL();
        
    //Obtenemos los valores de usuario y contraseña 
    $user = trim($data->user);
    $psw = trim($data->psw);
    
    $sql = "SELECT * FROM Usuario a
            WHERE  Usu_login = '$user' and Usu_pwd = '" . md5($psw) . "'";

    $result = $conexion->query($sql);
    $numero = $result->rowCount();
    
    if ($numero>0){

        $datos = $result->fetchAll(PDO::FETCH_OBJ);
        
    }else{

        $datos = array('respuesta' => 'El Usuario o contraseña son inorrectos');
    }
    
    echo json_encode($datos);

    $conexion = null;

}

if($funcion == 'busqueda'){
    
    //Obtenemos los datos que mandamos de angular
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $folio = $datos->folio;


    $conexion = conectarMySQL();

    $sql = "SELECT Exp_folio as folio, Exp_completo as nombre, Uni_nombrecorto as unidad, Exp_telefono as telefono, Cia_nombrecorto as cliente, Exp_edad as edad  
            FROM Expediente a
            INNER JOIN Unidad b on a.Uni_clave = b.Uni_clave
            INNER JOIN Compania c on c.Cia_clave = a. Cia_clave
            where Exp_folio= '$folio'";

        foreach ($conexion->query($sql) as $row) {

            $nombre = $row['nombre'];
            $unidad = $row['unidad'];
            $telefono = $row['telefono'];
            $cliente = $row['cliente'];
            $edad = $row['edad'];

        }

    $db = null;

    $datos = array('respuesta' => 'Folio Consultado)', 'folio' => $folio ,'nombre' => $nombre, 'unidad' => $unidad, 'telefono' => $telefono, 'cliente' => $cliente, 'edad' => $edad);

    echo json_encode($datos);
    //echo $sql;
        
}

if ($funcion == 'agregaevento') {

    $title = $_REQUEST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];


    $db = conectarMySQL();


        $sql = "INSERT INTO evenement (

                       id, title, start, end, url, allDay


                         
                ) VALUES ('','$title', '$start', '$end', '', 'false')";
        
        $temporal = $db->prepare($sql);


        $temporal->bindParam("title", $title);
        $temporal->bindParam("start", $start);
        $temporal->bindParam("end", $end);

        
        if ($temporal->execute()){
            $respuesta = array('respuesta' => "Evento Guardado");
        }else{
            $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información");
        }

            echo json_encode($respuesta);
            //echo $sql;
    $conexion = null;
}

if($funcion == 'buscaLesionadoxclinica'){
    
    //Obtenemos los datos que mandamos de angular
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    $conexion = conectarMySQL();
    
    //Obtenemos los valores de usuario y contraseña 

    $folio = $data->folio;
    $lesionado = $data->lesionado;
    $poliza = $data->poliza;
    $reporte = $data->reporte;
    $unidad = $data->unidad;
    $fnacimiento = $data->fnacimiento;
    $telefono = $data->telefono;


    $sql = "SELECT Expediente.Exp_folio as folio, Expediente.UNI_clave as claveunidad, Unidad.UNI_nombrecorto as unidad ,Expediente.Exp_poliza as poliza,
                    Expediente.Exp_siniestro as siniestro,Expediente.EXP_reporte as reporte,
                    Exp_completo as nombre, Exp_fecreg as fecharegistro, Exp_edad as edad, Exp_telefono as telefono,
                    Expediente.Cia_clave as clavecliente, Compania.Cia_nombrecorto as cliente
            FROM Expediente
            inner join Unidad on Unidad.Uni_clave = Expediente.Uni_clave
            inner join Compania on Compania.Cia_clave = Expediente.Cia_clave
            WHERE  Unidad.Uni_clave <> 8 and Unidad.Uni_clave = $unidad and EXP_cancelado = 0";

        if ($telefono!= '') {

            $criterio00 .= " AND Exp_telefono='$telefono'";

        }else{
            $criterio00 = "";
        }

        if ($fnacimiento != '') {

            $criterio0 .= " AND Exp_fechaNac2 like '%$fnacimiento%'";

        }else{
            $criterio0 = "";
        }


        if ($folio != '') {
            
            // $criterio1 = " WHERE ";
            $criterio1 .= " AND Expediente.Exp_folio = '$folio'";

        }else{
            $criterio1 = "";
        }

        if ($fechaini != '' && $fechafin != '') {

            // if ($criterio1 == "") {
            //     $criterio2 = " WHERE ";
            // }else{
            //     $criterio2 = " AND ";
            // }

           $criterio2 .= " AND Exp_fecreg BETWEEN '$fechaini 00:00:00' and '$fechafin 23:59:59'";
           
        }else{
            $criterio2 = "";
        }

        if ($lesionado != '') {

            // if ($criterio1 == "" && $criterio2 == "") {
            //     $criterio3 = " WHERE ";
            // }else{
            //     $criterio3 = " AND ";
            // }

            $criterio3 .= " AND Exp_completo like '%$lesionado%' ";

        }else{
            $criterio3 = "";
        }

        if ($poliza != '') {

            // if ($criterio1 == '' && $criterio2 == '' && $criterio3 == '') {
            //     $criterio4 = " WHERE ";
            // }else{
            //     $criterio4 = " AND ";
            // }

            $criterio4 .= " AND Exp_poliza = $poliza ";

        }else{

            $criterio4 = "";

        }

        if ($reporte != '') {

            // if ($criterio1 == '' && $criterio2 == '' && $criterio3 == '' && $criterio4 == '') {
            //     $criterio5 = " WHERE ";
            // }else{
            //     $criterio5 = " AND ";
            // }

            $criterio5 .= " AND EXP_reporte = $reporte ";

        }else{
            $criterio5 = "";
        }


        if ($siniestro != '') {

            // if ($criterio1 == '' && $criterio2 == '' && $criterio3 == '' && $criterio4 == '' && $criterio5 == '') {
            //     $criterio6 = " WHERE ";
            // }else{
            //     $criterio6 = " AND ";
            // }

            $criterio6 .= " AND Exp_siniestro = $siniestro ";

        }else{
            $criterio6 = "";
        }

        $criterio7 = " ORDER BY Exp_fecreg DESC LIMIT 5";


        $sql .= $criterio00 . $criterio0 . $criterio1 . $criterio2 . $criterio3 . $criterio4 . $criterio5 . $criterio6 . $criterio7;
        
        // if($criterio1 == '' && $criterio2 == '' && $criterio3 == '' && $criterio4 == '' && $criterio5 == '' && $criterio6 == ''){

        //     $sql .= " ORDER BY Exp_fecreg DESC LIMIT 10";
        // }


    $result = $conexion->query($sql);

    $cuenta = $result->rowCount();
    
    // foreach ($result as $row) {
                   
    //                $folio = $row['folio'];
    //                $unidad = $row['unidad'];
    //                $poliza = $row['poliza'];
    //                $siniestro = $row['siniestro'];
    //                $reporte = $row['reporte'];
    //                $nombre = $row['nombre'];
    //                $fecharegistro = $row['fecharegistro'];
    //                $edad = $row['edad'];
    //                $telefono = $row['telefono'];
    //                $cliente = $row['cliente'];
                
    //     }

        if($cuenta == 0) {

            $respuesta  = array('respuesta' => 'Lesionado no Registrado, Favor de realizar Registro');

            } else {

            $respuesta = $result->fetchAll(PDO::FETCH_OBJ);
        }
        
        echo json_encode($respuesta);
        //echo $sql;
        //echo $cuenta;


    $conexion = null;

}

if ($funcion == 'clientes') {

    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{
        
        $sql = "SELECT Cia_clave as id, Cia_nombrecorto as nombre
                FROM Compania Where Cia_activa='S' group by id ORDER BY nombre";

        $result = $db->query($sql);
        $unidades = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($unidades);

    }
    
}

if ($funcion == 'unidades') {

    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{
        
        $sql = "SELECT Uni_clave as id, Uni_nombre as unidad FROM Unidad group by id ORDER BY unidad asc";

        $result = $db->query($sql);
        $unidades = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($unidades);
    }
    
}

if ($funcion == 'guardaLesionado') {

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $nombre = $datos->nombre;
    $edad = $datos->edad;
    $tipotelefono = $datos->tipotelefono;
    $telefono = $datos->telefono;
    $siniestro = $datos->siniestro;
    $poliza = $datos->poliza;
    $reporte = $datos->reporte;
    $cliente = $datos->cliente;
    $folio  = $datos->folio;
    $unidad = $datos->uni;

    
       $cadena="[^A-Z0-9]";  
       $clave = substr(eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())). eregi_replace($cadena, "", md5(rand())),  0, 5);
       $clave = strtoupper($clave); 
    

    $db = conectarMySQL();


        $sql = "INSERT INTO PacientePreregistro  (

                        PRE_clave, PRE_nombre, PRE_edad, Cia_clave, Exp_folio, PRE_fechahorafolio, PRE_siniestro, PRE_poliza, PRE_folioelectronico, PRE_reporte, TT_clave, PRE_telefono, UNI_clave
                         
                ) VALUES ('$clave', '$nombre', '$edad', $cliente, '$folio', now(), '$siniestro', '$poliza', '', '$reporte', '$tipotelefono', '$telefono', '$unidad')";
        
        $temporal = $db->prepare($sql);


        $temporal->bindParam("clave", $clave);
        $temporal->bindParam("nombre", $nombre);
        $temporal->bindParam("edad", $edad);
        $temporal->bindParam("cliente", $cliente);
        $temporal->bindParam("folio", $folio);
        $temporal->bindParam("siniestro", $siniestro);
        $temporal->bindParam("poliza", $poliza);
        $temporal->bindParam("reporte", $reporte);
        $temporal->bindParam("tipotelefono", $tipotelefono);
        $temporal->bindParam("telefono", $telefono);
        $temporal->bindParam("uni", $unidad);
     
        
        if ($temporal->execute()){
            $respuesta = array('respuesta' => "Registro de Lesionado Exitoso", 'pre_clave' => $clave, 'folio' => $folio);
        }else{
            $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información");
        }

            echo json_encode($respuesta);
            //echo $sql;

    $db = null;
}

if ($funcion == 'estados') {

    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{
        
        $sql = "SELECT EST_claveint as clave, EST_nombre as estado FROM Estado order by estado asc";

        $result = $db->query($sql);
        $estados = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estados);

    }
    
}

if ($funcion == 'consultalocalidad') {

    $postdata = file_get_contents("php://input");

    $datos = json_decode($postdata);

    $estado = $datos->estado;
   
    $db = conectarMySQL();


        $sql = "SELECT LOC_claveint as clave, LOC_nombre as localidad FROM Localidad where EST_claveint = '$estado' order by localidad asc";

        $result = $db->query($sql);
        $localidad = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($localidad);

    }

if ($funcion == 'consultaunidad') {

    $postdata = file_get_contents("php://input");

    $datos = json_decode($postdata);

    $localidad = $datos->localidad;
   
    $db = conectarMySQL();


        $sql = "SELECT Uni_clave as clave, Uni_nombrecorto as unidad FROM Unidad a
                LEFT JOIN Localidad b on a.LOC_claveint = b.LOC_claveint
                where a.LOC_claveint = '$localidad' order by unidad asc";

        $result = $db->query($sql);
        $unidad = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($unidad);

}

if ($funcion == 'lesionadoregistrado') {

    $clave = $_REQUEST['clave'];

    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{
        
        $sql = "SELECT PRE_clave as clave, PRE_nombre as nombre, PRE_edad as edad, Cia_nombrecorto as cliente, Exp_folio as folio,
                   PRE_fechahorafolio as fechafolio, PRE_siniestro as siniestro, PRE_poliza as poliza, PRE_folioelectronico as folioelectronico,
                   PRE_reporte as reporte, TT_tipotelefono as tipotelefono, PRE_telefono as telefono, UNI_nombrecorto as unidad
                    FROM PacientePreregistro a
                    LEFT JOIN Compania b on a.Cia_clave = b.Cia_clave
                    LEFT JOIN Unidad c on a.UNI_clave = c. UNI_clave
                    LEFT JOIN TipoTelefono d on a.TT_clave = d.TT_clave
                    WHERE PRE_clave = '$clave'";

        foreach ($db->query($sql) as $row) {

            $nombre = $row['nombre'];
            $edad = $row['edad'];
            $cliente = $row['cliente'];
            $folio = $row['folio'];
            $fechafolio = $row['fechafolio'];
            $siniestro = $row['siniestro'];
            $poliza = $row['poliza'];
            $folioelectronico = $row['folioelectronico'];
            $reporte = $row['reporte'];
            $tipotelefono = $row['tipotelefono'];
            $telefono = $row['telefono'];
            $unidad = $row['unidad'];


        }

        $db = null;

        $respuesta  = array('respuesta' => 'datos consultados', 'nombre' => $nombre, 'edad' => $edad, 'cliente' => $cliente, 'folio' => $folio, 'fechafolio' => $fechafolio,
                            'siniestro' => $siniestro, 'poliza' => $poliza, 'folioelectronico' => $folioelectronico, 'reporte' => $reporte, 'tipotelefono' => $tipotelefono,
                            'telefono' => $telefono, 'unidad' => $unidad);

        echo json_encode($respuesta);
        //echo $sql;

    }
    
}

if ($funcion == 'tipocita'){

    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{
        
        $sql = "SELECT TC_clave as clave, TC_nombre as nombre, TC_tiempos as tiempo FROM TipoCita";

        $result = $db->query($sql);
        $tipoCita = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($tipoCita);

    }

}

if ($funcion == 'consultacalendario') {

    $postdata = file_get_contents("php://input");

    $datos = json_decode($postdata);

    $unidad = $datos->unidades;
    $foliocita = $datos->foliocita;
   
    $db = conectarMySQL();

        $sql = "SELECT a.PRE_clave, PRE_nombre, PRE_edad, Cia_clave, Exp_folio, PRE_fechahorafolio, PRE_siniestro, PRE_poliza, PRE_folioelectronico, PRE_reporte, TT_clave, PRE_telefono, Uni_calleNum as calle, Uni_colMun as colonia, Uni_tel, Uni_estado
                FROM Cita a
                LEFT JOIN PacientePreregistro b on a.PRE_clave = b.PRE_clave
                LEFT JOIN Unidad c on b.UNI_clave = c.UNI_clave
                where b.UNI_clave = '$unidad' and a.PRE_clave = '$foliocita'";

        foreach ($db->query($sql) as $row) {

            $calle = $row['calle'];
            $colonia = $row['colonia'];

        }

        $db = null;

        $respuesta  = array('respuesta' => 'datos consultados', 'calle' => $calle, 'colonia' => $colonia);
        echo json_encode($respuesta);
        //echo $sql;

}

if ($funcion == 'guardaCita') {

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

      $clavepaciente = $datos->clavepaciente;
      $duracion = $datos->duracion;
      $fecha = $datos->fecha;
      $horacita = $datos->horacita;
      $observacion = $datos->observacion;
      $tipocita = $datos->tipocita;
      $usuario = $datos->usuario;
      $unidad = $datos->unidad;
      $asunto = $datos->asunto;

      $inicio = $fecha.' '.$horacita;

       $cadena="[^A-Z0-9]";  
       $clavecita = substr(eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())). eregi_replace($cadena, "", md5(rand())),  0, 5);
       $clavecita = strtoupper($clavecita); 

       $hoy = date("Y-m-d H:i:s");
  
    $db = conectarMySQL();

    // AQUI SE CHECARA FECHA Y HORAS OCUPADAS

    $compara = "SELECT CT_clave, PRE_clave, TC_clave, CT_fecha, CT_hora, CT_tiempo, CT_observaciones, USU_registro, CT_utilizada, CT_registrocita, CT_termino, Uni_clave
                FROM Cita
                WHERE str_to_date('$fecha','%Y-%m-%d') and TC_clave = '$tipocita' and Uni_clave = '$unidad'
                and
                (
                DATE_ADD(CAST(CONCAT(STR_TO_DATE('$fecha','%Y-%m-%d'),' ','$horacita') AS DATETIME),INTERVAL 0 MINUTE) <= CAST(CT_termino AS DATETIME)
                AND
                DATE_SUB(CAST(CONCAT(STR_TO_DATE('$fecha','%Y-%m-%d'),' ','$horacita') AS DATETIME),INTERVAL 0 MINUTE) >= CAST(CONCAT(CT_fecha,' ',CT_hora) AS DATETIME)
                )";

        $result = $db->query($compara);
        $numero = $result->rowCount();

        //echo $numero;


        if ($unidad ==  2 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita ==  3) and $numero == 4) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 4");
        }else if ($unidad ==  3 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita ==  3) and $numero == 4) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 4");

        }else if ($unidad ==  184 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita ==  3) and $numero == 4) {
            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 4");

        }else if ($unidad ==  1 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita ==  3) and $numero == 4) {
            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 4");

        }else if ($unidad ==  86 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita ==  3) and $numero == 4) {
            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 4");

        }else if ($unidad ==  186 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita ==  3) and $numero == 4) {
            
            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 4");
        }else if ($unidad ==  86 and ($tipocita ==  4) and $numero == 2) {
            # code...
            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");

        }else if ($unidad ==  2 and ($tipocita ==  4) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
        }elseif ($unidad ==  3 and ($tipocita ==  4) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  184 and ($tipocita ==  4) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  1 and ($tipocita ==  4) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  186 and ($tipocita ==  4) and $numero == 2) {

             $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");

        }elseif ($unidad ==  4 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita == 3) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  6 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita == 3) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  7 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita == 3) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  5 and ($tipocita ==  2 or $tipocita ==  5 or $tipocita ==  1 or $tipocita == 3) and $numero == 2) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 2");
            # code...
        }elseif ($unidad ==  4 and ($tipocita ==  4) and $numero == 1 ) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 1");
            # code...
        }elseif ($unidad ==  6 and ($tipocita ==  4) and $numero == 1 ) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 1");
            # code...
        }elseif ($unidad ==  7 and ($tipocita ==  4) and $numero == 1 ) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 1");
            # code...
        }elseif ($unidad ==  5 and ($tipocita ==  4) and $numero == 1 ) {

            $respuesta = array('respuesta' => "No puedes agendar mas citas Num: 1");
            # code...
        }else{

        $sql = "INSERT INTO Cita  (

                CT_clave, PRE_clave, TC_clave, CT_fecha, CT_hora, CT_tiempo, CT_observaciones, USU_registro, CT_utilizada, CT_registrocita, CT_termino, Uni_clave 

                         
                ) VALUES ('$clavecita', '$clavepaciente', '$tipocita', '$fecha', '$horacita', '$duracion', '$observacion', '$usuario', '0', '$hoy', DATE_ADD('$fecha $horacita',INTERVAL $duracion MINUTE), '$unidad')";
        
        $temporal = $db->prepare($sql);

        $temporal->bindParam("clavecita", $clavecita);
        $temporal->bindParam("clavepaciente", $clavepaciente);
        $temporal->bindParam("tipocita", $tipocita);
        $temporal->bindParam("duracion", $duracion);
        $temporal->bindParam("fecha", $fecha);
        $temporal->bindParam("horacita", $horacita);
        $temporal->bindParam("duracion", $duracion);
        $temporal->bindParam("observacion", $observacion);
        $temporal->bindParam("usuario", $usuario);
        $temporal->bindParam("unidades", $unidad);

        $temporal->execute();


        $sql1 = "INSERT INTO Citaevento (

                       id, CT_clave ,title, start, end, url, allDay, bloqueo


                         
                ) VALUES ('', '$clavecita' ,'$asunto', '$inicio', DATE_ADD('$fecha $horacita',INTERVAL $duracion MINUTE), '', 'false', 'Si')";
        
        $temporal1 = $db->prepare($sql1);


        $temporal1->bindParam("title", $asunto);
        $temporal1->bindParam("start", $inicio);
        $temporal1->bindParam("duracion", $duracion);
        $temporal1->bindParam("fecha", $fecha);
        $temporal1->bindParam("horacita", $horacita);
        $temporal1->bindParam("asunto", $asunto);
        $temporal1->bindParam("clavecita", $clavecita);
     
        
        if ($temporal1->execute()){
            $respuesta = array('respuesta' => "Cita Agendada", 'clavecita' => $clavecita);
        }else{
            $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información");
        }

}
            echo json_encode($respuesta);
             //echo $sql1;
             //echo $compara;

    $db = null;
}

///////////////////////////////////// CLINICAS ////////////////////////////////////////////////////////////////////////


if ($funcion == 'localidadclinicas') {
   
    $db = conectarMySQL();


        $sql = "SELECT LOC_claveint as clave, LOC_nombre as localidad FROM Localidad
                WHERE LOC_claveint = 16 or LOC_claveint = 18 or LOC_claveint = 41 or LOC_claveint = 47 or
                LOC_claveint = 169 or LOC_claveint = 77 or LOC_claveint = 61 order by localidad asc";

        $result = $db->query($sql);
        $localidad = $result->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($localidad);
        //echo $sql;
    }

    if ($funcion == 'unidadclinica') {

    $postdata = file_get_contents("php://input");

    $datos = json_decode($postdata);

    $localidad = $datos->localidad;
   
    $db = conectarMySQL();

        $sql = "SELECT Uni_clave as clave, Uni_nombrecorto as unidad FROM Unidad a
                LEFT JOIN Localidad b on a.LOC_claveint = b.LOC_claveint
                where a.LOC_claveint = '$localidad' and Uni_propia = 'S' and Uni_clave<> 8 order by unidad asc";

        $result = $db->query($sql);
        $unidad = $result->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        echo json_encode($unidad);

}

if ($funcion == 'consultacitas') {

    $claveunidad = $_REQUEST['claveunidad'];

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    
    //$claveunidad = $data->search->unidad;
    $fechainicio = $data->search->fechainicio;
    $tipocita = $data->search->tipocita;


    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');
 
    }else{
        
        $sql ="SELECT CT_clave, a.PRE_clave, PRE_nombre ,a.TC_clave, TC_nombre, Exp_folio ,CT_fecha, CT_hora, CT_tiempo, CT_observaciones, USU_registro, CT_utilizada,
                CT_registrocita, CT_termino, a.Uni_clave, Uni_nombrecorto 
                FROM Cita a
                LEFT JOIN Unidad b on a.Uni_clave = b.Uni_clave
                LEFT JOIN TipoCita c on a.TC_clave = c.TC_clave
                LEFT JOIN PacientePreregistro d on a.PRE_clave = d.PRE_clave
                where a.Uni_clave = $claveunidad and CT_fecha='$fechainicio' and a.TC_clave='$tipocita' and a.PRE_clave not like '%bloqueo%' and CT_utilizada <> '1'";

         $resultat = $db->query($sql) or die(print_r($db->errorInfo()));

         echo json_encode($resultat->fetchAll(PDO::FETCH_OBJ));

        $db = null;

    }

}

if ($funcion == 'infounidad') {

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    
    $claveunidad = $data->unidad;


    $db = conectarMySQL();

        $sql = "SELECT Uni_clave as clave, Uni_nombrecorto as unidad, Uni_calleNum as calle, Uni_colMun as colonia, Uni_tel as telefono, 
                       Uni_estado as estado, Uni_latitud as latitud, Uni_longitud as longitud
                FROM Unidad WHERE Uni_clave = '$claveunidad'";

            foreach ($db->query($sql) as $row) {

            $clave = $row['clave'];
            $unidad = $row['unidad'];
            $calle = $row['calle'];
            $colonia = $row['colonia'];
            $telefono = $row['telefono'];
            $estado = $row['estado'];
            $latitud = $row['latitud'];
            $longitud = $row['longitud'];

        }

        $db = null;

        $ruta = "../imgclinicas/$claveunidad/";

      $directorio = opendir($ruta); //ruta actual
        while ($archivo1 = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (is_dir($archivo1))//verificamos si es o no un directorio
            {
                //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
            }
            else
            {   
     
                    $foto[]['image'] = "imgclinicas/$claveunidad/".$archivo1;
            }
        }

        $respuesta  = array('respuesta' => 'datos consultados', 'clave' => $clave, 'unidad' => $unidad, 'calle' => $calle, 'colonia' => $colonia,
                            'telefono' => $telefono, 'estado' => $estado, 'image' => $foto, 'latitud' => $latitud, 'longitud' => $longitud);

        echo json_encode($respuesta);


}


if($funcion == 'b_todasclinica'){
    
    //Obtenemos los datos que mandamos de angular
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    $conexion = conectarMySQL();
    
    //btenemos los valores de usuario y contraseña 

    $fnacimiento = $data->fnacimiento;
    $folio = $data->folio;
    $lesionado = $data->lesionado;
    $poliza = $data->poliza;
    $reporte = $data->reporte;
    $unidad = $data->unidad;
    $cliente = $data->cliente;
    $telefono = $data->telefono;


    $sql = "SELECT Expediente.Exp_folio as folio, Expediente.UNI_clave as claveunidad, Unidad.UNI_nombrecorto as unidad ,Expediente.Exp_poliza as poliza,
                    Expediente.Exp_siniestro as siniestro,Expediente.EXP_reporte as reporte,
                    Exp_completo as nombre, Exp_fecreg as fecharegistro, Exp_edad as edad, Exp_telefono as telefono,
                    Expediente.Cia_clave as clavecliente, Compania.Cia_nombrecorto as cliente
            FROM Expediente
            inner join Unidad on Unidad.Uni_clave = Expediente.Uni_clave
            inner join Compania on Compania.Cia_clave = Expediente.Cia_clave
            WHERE  Unidad.Uni_clave <> 8 and EXP_cancelado = 0";


    if ($telefono != '') {

            $criterio0 .= " AND Exp_telefono = '$telefono'";

    }else{
            $criterio0 = "";
    }

    if ($cliente) {
        
        $sql .= " AND Expediente.Cia_clave = $cliente";

    }else{

        if ($folio != '') {
            
            // $criterio1 = " WHERE ";
            $criterio1 .= " AND Expediente.Exp_folio = '$folio'";

        }else{
            $criterio1 = "";
        }

        if ($fnacimiento != '' ) {

            // if ($criterio1 == "") {
            //     $criterio2 = " WHERE ";
            // }else{
            //     $criterio2 = " AND ";
            // }

           $criterio2 .= " AND Exp_fechaNac2 = '$fnacimiento'";
           
        }else{
            $criterio2 = "";
        }

        if ($lesionado != '') {

            // if ($criterio1 == "" && $criterio2 == "") {
            //     $criterio3 = " WHERE ";
            // }else{
            //     $criterio3 = " AND ";
            // }

            $criterio3 .= " AND Exp_completo like '%$lesionado%' ";

        }else{
            $criterio3 = "";
        }

        if ($poliza != '') {

            // if ($criterio1 == '' && $criterio2 == '' && $criterio3 == '') {
            //     $criterio4 = " WHERE ";
            // }else{
            //     $criterio4 = " AND ";
            // }

            $criterio4 .= " AND Exp_poliza = $poliza ";

        }else{

            $criterio4 = "";

        }

        if ($reporte != '') {

            // if ($criterio1 == '' && $criterio2 == '' && $criterio3 == '' && $criterio4 == '') {
            //     $criterio5 = " WHERE ";
            // }else{
            //     $criterio5 = " AND ";
            // }

            $criterio5 .= " AND EXP_reporte = $reporte ";

        }else{
            $criterio5 = "";
        }


        if ($siniestro != '') {

            // if ($criterio1 == '' && $criterio2 == '' && $criterio3 == '' && $criterio4 == '' && $criterio5 == '') {
            //     $criterio6 = " WHERE ";
            // }else{
            //     $criterio6 = " AND ";
            // }

            $criterio6 .= " AND Exp_siniestro = $siniestro ";

        }else{
            $criterio6 = "";
        }

        $criterio7 = " ORDER BY Exp_fecreg DESC LIMIT 5";


        $sql .= $criterio0 .$criterio1 . $criterio2 . $criterio3 . $criterio4 . $criterio5 . $criterio6 . $criterio7;
        
        // if($criterio1 == '' && $criterio2 == '' && $criterio3 == '' && $criterio4 == '' && $criterio5 == '' && $criterio6 == ''){

        //     $sql .= " ORDER BY Exp_fecreg DESC LIMIT 10";
        // }

    }

    $result = $conexion->query($sql);

    $cuenta = $result->rowCount();
    

        if($cuenta == 0) {

            $respuesta  = array('respuesta' => 'Lesionado no Registrado, Favor de realizar Registro');

            } else {

            $respuesta = $result->fetchAll(PDO::FETCH_OBJ);
        }
        
        echo json_encode($respuesta);
        //echo $sql;
        //echo $cuenta;


    $conexion = null;

}

if($funcion == 'buscafolio'){

    $conexion = conectarMySQL();

    $folio = $_REQUEST['folio'];
    

    $sql = "SELECT Expediente.Exp_folio as folio, Expediente.UNI_clave as unidad ,Expediente.Exp_poliza as poliza,
                    Expediente.Exp_siniestro as siniestro,Expediente.EXP_reporte as reporte,
                    Exp_completo as nombre, Exp_fecreg as fecharegistro, Exp_edad as edad, Exp_telefono as telefono,
                    Expediente.Cia_clave as cliente
            FROM Expediente
            inner join Unidad on Unidad.Uni_clave = Expediente.Uni_clave
            inner join Compania on Compania.Cia_clave = Expediente.Cia_clave
            WHERE  Unidad.Uni_clave <> 8 and EXP_cancelado = 0 and Expediente.Exp_folio = '$folio'";

            $result = $conexion->query($sql);

            $cuenta = $result->rowCount();
            
            foreach ($result as $row) {
                           
                           $folio = $row['folio'];
                           $unidad = $row['unidad'];
                           $poliza = $row['poliza'];
                           $siniestro = $row['siniestro'];
                           $reporte = $row['reporte'];
                           $nombre = $row['nombre'];
                           $fecharegistro = $row['fecharegistro'];
                           $edad = $row['edad'];
                           $telefono = $row['telefono'];
                           $cliente = $row['cliente'];
                        
                }

            if($result == 0) {

                $respuesta  = array('respuesta' => 'No se agrego registro');

                }else{ 

                $respuesta = array('mensaje' => 'Exito', 'unidad' => $unidad, 'poliza' => $poliza, 'siniestro' => $siniestro, 'reporte' => $reporte, 'nombre' => $nombre,
                               'fecharegistro' => $fecharegistro, 'edad' => $edad, 'telefono' => $telefono, 'cliente' => $cliente, 'folio' => $folio);
            }
            
            echo json_encode($respuesta);
            //echo $sql;

    $conexion = null;

}

if($funcion == 'actualizarcita'){

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
    $conexion = conectarMySQL();
    
    //btenemos los valores de usuario y contraseña 
      $cita = $datos->cita;
      $duracion = $datos->duracioncita;
      $fecha = $datos->fechacita;
      $horacita = $datos->horacita;
      $observacion = $datos->obscita;
      $tipocita = $datos->tipocitaclave;
      $asunto = $datos->asunto;

    $conexion = conectarMySQL();
    

    $sql = "UPDATE Cita
            SET CT_fecha = '$fecha', CT_hora = '$horacita', CT_tiempo = '$duracion', TC_clave = '$tipocita', CT_observaciones = '$observacion'
            WHERE CT_clave = '$cita'";

            $result = $conexion->query($sql);


            $respuesta = array('mensaje' => 'Se actualizo con exito');
            
            echo json_encode($respuesta);
            //echo $sql;

    $conexion = null;


}

if ($funcion == 'citaBloqueada') {

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

     $db = conectarMySQL();

      $clavepaciente = $datos->clavepaciente;
      $duracion = $datos->duracion;
      $fechainicio = $datos->fechainicio;
      $horainicio = $datos->horainicio;
      $fechafinal = $datos->fechafinal;
      $horafinal = $datos->horafinal;
      $observacion = $datos->observacion;
      $tipocita = $datos->tipocita;
      $usuario = $datos->usuario;
      $asunto = $datos->asunto;
      $inicio = $fechainicio.' '.$horafinal;
      $unidad= $datos->unidad;

       $hoy = date("Y-m-d H:i:s");

       $cadena_cita = implode(";", $tipocita);
       $cita = explode(";", $cadena_cita);
        # code...
       foreach ($cita as $c) {  

       $cadena="[^A-Z0-9]";  
       $clavecita = substr(eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())). eregi_replace($cadena, "", md5(rand())),  0, 5);
       $clavecita = strtoupper($clavecita); 
   
    // AQUI SE CHECARA FECHA Y HORAS OCUPADAS

    $compara = "SELECT CT_clave, PRE_clave, TC_clave, CT_fecha, CT_hora, CT_tiempo, CT_observaciones, USU_registro, CT_utilizada, CT_registrocita, CT_termino, Uni_clave
                FROM Cita
                WHERE str_to_date('$fecha','%Y-%m-%d') and TC_clave = '$c' and Uni_clave = '$unidad'
                and
                (
                DATE_ADD(CAST(CONCAT(STR_TO_DATE('$fechainicio','%Y-%m-%d'),' ','$horainicio') AS DATETIME),INTERVAL 0 MINUTE) <= CAST(CT_termino AS DATETIME)
                AND
                DATE_SUB(CAST(CONCAT(STR_TO_DATE('$fechainicio','%Y-%m-%d'),' ','$horainicio') AS DATETIME),INTERVAL 0 MINUTE) >= CAST(CONCAT(CT_fecha,' ',CT_hora) AS DATETIME)
                )";

        $result = $db->query($compara);
        $numero = $result->rowCount();   
 
        if ($numero > 0 ) {
            $respuesta = array('respuesta' => "Existe una Cita a esa hora");
        } else {

        $sql = "INSERT INTO Cita  (

                CT_clave, PRE_clave, TC_clave, CT_fecha, CT_hora, CT_tiempo, CT_observaciones, USU_registro, CT_utilizada, CT_registrocita, CT_termino, Uni_clave 

                         
                ) VALUES ('$clavecita', 'bloqueo', '$c', '$fechainicio', '$horainicio', '0', '$observacion', '$usuario', '0', '$hoy', '$fechafinal $horafinal', '$unidad')";
        
        $temporal = $db->prepare($sql);

        $temporal->bindParam("clavecita", $clavecita);
        $temporal->bindParam("clavepaciente", $clavepaciente);
        $temporal->bindParam("tipocita", $tipocita);
        $temporal->bindParam("fechainicio", $fecha);
        $temporal->bindParam("horainicio", $horacita);
        $temporal->bindParam("fechafinal", $fechafinal);
        $temporal->bindParam("horafinal", $horafinal);
        $temporal->bindParam("duracion", $duracion);
        $temporal->bindParam("observacion", $observacion);
        $temporal->bindParam("usuario", $usuario);
        $temporal->bindParam("unidades", $unidad);

        $temporal->execute();    

        $sql1 = "INSERT INTO Citaevento (

                       id, CT_clave ,title, start, end, url, allDay, bloqueo
                         
                ) VALUES ('', '$clavecita' ,'$asunto', '$inicio','$fechafinal $horafinal', '', 'false', 'Si')";
        
        $temporal1 = $db->prepare($sql1);


        $temporal1->bindParam("title", $asunto);
        $temporal1->bindParam("start", $inicio);
        $temporal1->bindParam("duracion", $duracion);
        $temporal1->bindParam("fechafinal", $fechafinal);
        $temporal1->bindParam("horafinal", $horafinal);
        $temporal1->bindParam("asunto", $asunto);
        $temporal1->bindParam("clavecita", $clavecita);

        $temporal1->execute();

    }
}
        
            $respuesta = array('respuesta' => "Dias Bloqueados");
    
        echo json_encode($respuesta);

    $db = null;
}

if ($funcion == 'enviainformacion') {

    include_once('mail/nomad_mimemail.inc.php');

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    
    $claveunidad = $data->unidad;
    $correo = $data->correo;


    $db = conectarMySQL();

        $sql = "SELECT Uni_clave as clave, Uni_nombrecorto as unidad, Uni_calleNum as calle, Uni_colMun as colonia, Uni_tel as telefono, 
                       Uni_estado as estado, Uni_latitud as latitud, Uni_longitud as longitud
                FROM Unidad WHERE Uni_clave = '$claveunidad'";

            foreach ($db->query($sql) as $row) {

            $clave = $row['clave'];
            $unidad = $row['unidad'];
            $calle = $row['calle'];
            $colonia = $row['colonia'];
            $telefono = $row['telefono'];
            $estado = $row['estado'];
            $latitud = $row['latitud'];
            $longitud = $row['longitud'];

        }

        $db = null;

        $ruta = "../imgclinicas/$claveunidad/";

      $directorio = opendir($ruta); //ruta actual
        while ($archivo1 = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (is_dir($archivo1))//verificamos si es o no un directorio
            {
                //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
            }
            else
            {   
     
                    $foto[]['image'] = "imgclinicas/$claveunidad/".$archivo1;
            }
        }

        $html= "<style type='text/css'>
            .clase {
                color: #224B99;
                font-weight: bold;
                font-size: 16px;
            }
            </style>";

        $html.= "<font size='4'>$unidad</font><br><br><br><br>";
        $html.= "<font size='2'>Direccion: $calle $colonia</font><br>";
        $html.= "<font size='2'>Telefono: $telefono</font><br>";

        
        $mimemail = new nomad_mimemail();
        $mimemail->set_from("reportes@medicavial.com.mx");
        $mimemail->add_to("$correo");
        $mimemail->set_subject("Informacion de la Clinica");        
        $mimemail->set_html($html);

        if ($mimemail->send()){  
            $correo = "Exito";
        }else{ 
            $correo = "Error";
        }
   
        $respuesta  = array('respuesta' => 'datos consultados', 'clave' => $clave, 'unidad' => $unidad, 'calle' => $calle, 'colonia' => $colonia,
                            'telefono' => $telefono, 'estado' => $estado, 'image' => $foto, 'latitud' => $latitud, 'longitud' => $longitud);

        echo json_encode($respuesta);

        //echo $html;

}

if ($funcion == 'color1') {

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    
    $unidad = $data->unidad;

    $db = conectarMySQL();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');
 
    }else{
        
        $sql ="select a1. title,start, end, url, allDay, bloqueo, total1, total2, (total1/total2) as porcentaje  FROM

                (SELECT '' as a, id, CT_clave, title, start, end, url, allDay, bloqueo FROM Citaevento
                ) a1

                left join

                (Select '' as a,count(*) as total1 from Expediente
                inner join Unidad on Expediente.Uni_clave=Unidad.Uni_clave
                where Unidad.Uni_propia='S' and
                Unidad.Uni_activa='S'
                and Unidad.Uni_clave= '$unidad'
                and Exp_fecreg between '2015-05-04' and '2015-05-05')
                a2 On a1.a=a2.a

                left join

                (
                Select '' as a,count(a.Exp_folio) as total2
                from PacientePreregistro a
                inner join Unidad b on a.Uni_clave=b.Uni_clave
                where a.Uni_clave= '$unidad' )
                a3 On a1.a=a3.a

                group by date(start)";


        foreach ($db->query($sql) as $row) {

            $porcentaje = $row['porcentaje'];

        }

        $db = null;

        $respuesta  = array('porcentaje' => $porcentaje);

        echo json_encode($respuesta);

    }
    
}

if ($funcion == 'evento') {

    $db = conectarMySQL();

    $unidad = $_REQUEST['unidad'];
    $tipocita = $_REQUEST['tipocita'];


    if(!$db) {

        die('Something went wrong while connecting to MSSQL');
 
    }else{
        
        $sql = "select a1. title,start, end, url, allDay, bloqueo, total2, (total2/50)*100 as porcentaje,
                if((total2/50)*100  <= 25,'#CDC9C9',if((total2/50)*100  > 25 and (total2/50)*100  <= 75,'#C3FCCF',if((total2/50)*100  > 75,'#FCE6AB','algo esta mal'))) as color  FROM

                (SELECT count(a.CT_clave) as total2, id, a.CT_clave, title, start, end, url, allDay, bloqueo
                 FROM Citaevento a
                 inner join Cita b on a.CT_clave=b.CT_clave
                 where b.Uni_clave= '$unidad' and b.TC_clave= '$tipocita' group by date(start)
                ) a1 group by date(start)";

         $resultat = $db->query($sql) or die(print_r($db->errorInfo()));

 // sending the encoded result to success page
         echo json_encode($resultat->fetchAll(PDO::FETCH_OBJ));

        $db = null;

    }
    
}

if($funcion == 'checabloqueo'){

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
    $conexion = conectarMySQL();
    
    //btenemos los valores de usuario y contraseña 
      $fecha = $datos->fechainicio;
      $unidad = $datos->unidad;
      $tipocita = $datos->tipocita;

    $conexion = conectarMySQL();
    

    $sql = "SELECT CT_clave, PRE_clave, TC_clave, CT_fecha, CT_hora, CT_tiempo, CT_observaciones, USU_registro, CT_utilizada,
            CT_registrocita, CT_termino, Uni_clave FROM Cita
            where PRE_clave like '%bloqueo%' and Uni_clave='$unidad' and TC_clave='$tipocita' and
            (CT_fecha <= '$fecha' and date(CT_termino) >= '$fecha')";

            $result = $conexion->query($sql);

            foreach ($conexion->query($sql) as $row) {

                $nombre = $row['nombre'];
                $unidad = $row['unidad'];
                $telefono = $row['telefono'];
                $cliente = $row['cliente'];
                $edad = $row['edad'];

            }

            $numero = $result->rowCount(); 

            if ($numero>0) {

                $respuesta = array('respuesta' => "Dia bloqueado $fecha", 'bloqueo' => true);

            }else{

                $respuesta = array('respuesta' => "0 dias", 'bloqueo' => false);
            }
            
            echo json_encode($respuesta);
            //echo $sql;

    $conexion = null;
}

if($funcion == 'pasarConsulta'){

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
    $conexion = conectarMySQL();
    
    //btenemos los valores de usuario y contraseña 
    $cita = $datos->cita;

    $conexion = conectarMySQL();
    

    $sql = "UPDATE Cita
            SET CT_utilizada = '1'
            WHERE CT_clave = '$cita'";

            $result = $conexion->query($sql);


            $respuesta = array('mensaje' => 'Se actualizo con exito');
            
            echo json_encode($respuesta);
            //echo $sql;

    $conexion = null;

}


?>