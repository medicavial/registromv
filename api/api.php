<?php
//tiempo de espera en caso de tardar mas de 30 segundos una consulta grande prueba
set_time_limit(3600);
//sin limite me memoria 
ini_set('memory_limit', '-1');
//ocultar los errores
error_reporting(0);

date_default_timezone_set('America/Mexico_City'); //Ajustando zona horaria


function ultimodiadelmes($mes) { 
      $month = date($mes);
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
};
 
  /** Actual month first day **/
function primerdiadelmes($mes) {
  $month = date($mes);
  $year = date('Y');
  return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
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
        $valor .= substr($todos,rand(0,29),1);

        return $valor;

} 


function generar_numero(){ 

        $valor = '';

        $pares = '24680';
        $nones = '13579';
        $consonantes = "BCDEFGHIJKLMNOPQRSTUVWXYZ";
        $todos =  $pares . $consonantes . $nones;
       
        $valor .= substr($pares,rand(0,4),1);
        $valor .= substr($nones,rand(0,4),1);
        $valor .= substr($todos,rand(0,34),1);
        return $valor;

} 

function conectarMySQL(){

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
    
    $sql = "SELECT * FROM Usuario
            WHERE Usu_login = '$user' and Usu_pwd = '" . md5($psw) . "'";

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

if($funcion == 'buscaExpedientes'){
    
   
}


if($funcion == 'unidades'){

    $conexion = conectarMySQL();

    $sql = "SELECT * FROM Compania order BY Cia_nombrecorto";

    $result = $conexion->query($sql);

    $resultado = array();
    $total = array();

    //$datos = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $value) {

        $clave = $value['Cia_clave'];
        $nombre = $value['Cia_nombrecorto'];
        $activa = $value['Cia_activa'];

        if ($activa == 'S') {

            $resultado['clave'] = $clave;
            $resultado['nombre'] = $nombre;

            array_push($total, $resultado);

        }elseif ($activa == 'N' && $clave == '52') {

            $resultado['clave'] = $clave; 
            $resultado['nombre'] = $nombre;

            array_push($total, $resultado);

        }

        

    } 

    echo json_encode($total);

    $conexion = null;

}


if($funcion == 'usuario'){

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $data = json_decode($postdata);
    $conexion = conectarMySQL();
    
    $nombre = $data->nombre;
    $usuario = $data->usuario;
    $psw = md5($data->psw);
    $admin = $data->admin;
    $correo = $data->correo;
    $empresa = $data->empresa;


    $sqlDet = "SELECT * FROM UsuarioInfoWeb 
                WHERE USU_login = '$usuario'";
    $result = $conexion->query($sqlDet);
    $numero = $result->rowCount();
    
    if ($numero>0){

        $respuesta = array('respuesta' => 'El Usuario ya existe');
        
    }else{

        $sql = "INSERT INTO UsuarioInfoWeb (
                        USU_nombre
                        ,USU_login
                        ,USU_password
                        ,USU_fechaReg
                        ,USU_activo
                        ,USU_administrador
                        ,USU_correo
                        ,Cia_clave
                ) VALUES (:nombre,:usuario,:psw,now(),1,:admin,:correo,:empresa)";

        $temporal = $conexion->prepare($sql);

        // $temporal->bindParam("clave", $clave, PDO::PARAM_INT);
        // $temporal->bindParam("nombre", $nombre, PDO::PARAM_STR);

        $temporal->bindParam("nombre", $nombre);
        $temporal->bindParam("usuario", $usuario);
        $temporal->bindParam("psw", $psw);
        $temporal->bindParam("admin", $admin);
        $temporal->bindParam("correo", $correo);
        $temporal->bindParam("empresa", $empresa);
        
        if ($temporal->execute()){
            $respuesta = array('respuesta' => "Los Datos se guardaron Correctamente");
        }else{
            $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información");
        }
        
    }


    
    echo json_encode($respuesta);

    $conexion = null;

}


if($funcion == 'usuarios'){

    $conexion = conectarMySQL();

    $sql = "SELECT * FROM Usuario";

    $result = $conexion->query($sql);

    $datos = $result->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($datos);

    $conexion = null;

}

if ($funcion == 'registra') {


    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $nombre = $datos->nombre;
    $apPat = $datos->pat;
    $apMat = $datos->mat;
    $fecharegistro = $datos->fecnac;
    $tipTel = $datos->tel;
    $tel = $datos->numeroTel;
    $correo = $datos->mail;

    $nomComp= $nombre.' '.$apPat.' '.$apMat;
    switch ($tipTel) {
    case 1:
        $tipoTel="Particular";
        break;
    case 2:
        $tipoTel="Oficina";
        break;
    case 3:
        $tipoTel="Móvil";
        break;
    case 4:
        $tipoTel="Otro";
        break;                    
    default:                      
        break;
    }  

    $telefono = $tipoTel.'-'.$tel;  

    $db = conectarMySQL();



    $sql = "Select Uni_clave From Usuario Where Usu_login='".$usr."'";
    $result = $db->query($sql);
    $uniClave = $result->fetchAll();    

    foreach ($uniClave as $key ) {
        $uni = $key['Uni_clave'];
    };    
    $sql = "Select Pre_prefijo From Prefijo Where Uni_clave='".$uni."'";
    $result = $db->query($sql);
    $ultimo = $result->fetchAll();     
    foreach ($ultimo as $key) {
        $prefijo=$key[0];
    }
    $sql = "Select MAX(EXP_cons)+1 From Expediente Where Exp_prefijo='".$prefijo."'";
    $result = $db->query($sql);
    $consecutivo = $result->fetchAll();     
    foreach ($consecutivo as $key) {
        $cons=$key[0];
    }    
    if ($cons==null) {$cons=1;}
    $c="000000".$cons;
    $c=substr($c,-6,6);
    $folio=$prefijo.$c;

    $sql="Insert into Expediente (
                        Exp_folio, 
                        Exp_prefijo, 
                        Exp_cons, 
                        Uni_clave, 
                        Usu_registro, 
                        Exp_paterno, 
                        Exp_materno,  
                        Exp_nombre,Exp_completo, 
                        Exp_fechaNac, 
                        Exp_fechaNac2, 
                        Exp_mail, 
                        Exp_telefono, 
                        Exp_fecreg, 
                        Cia_clave,                       
                        Pro_clave)
            VALUES(:folio,:prefijo,:cons,:uni_clave,:usu_registro,:apPat,:apMat,:nombre,:nomComp,:fecNa,:fecNa1,:mail,:telefono,now(),:ciaClave,:proClave)";




    $temporal = $db->prepare($sql);

    $temporal->bindParam("folio", $folio);
    $temporal->bindParam("prefijo", $prefijo);
    $temporal->bindParam("cons", $cons);
    $temporal->bindParam("uni_clave", $uni);
    $temporal->bindParam("usu_registro", $usr);
    $temporal->bindParam("apPat", $apPat);
    $temporal->bindParam("apMat", $apMat);
    $temporal->bindParam("nombre", $nombre);
    $temporal->bindParam("nomComp", $nomComp);
    $temporal->bindParam("fecNa", $fecharegistro);
    $temporal->bindParam("fecNa1", $fecharegistro);
    $temporal->bindParam("mail", $correo);
    $temporal->bindParam("telefono", $telefono);        
    $temporal->bindParam("ciaClave", $ciaClave);
    $temporal->bindParam("proClave", $prod);

    
    if ($temporal->execute()){
    	require('classes/generaCDB_resp.php');        
        $genera=new generaCDB_resp();
        $resp=$genera->generaCodigo($folio);
        $respuesta = array('respuesta' => 'Los datos Se Guardaron Correctamente', 'folio'=>$folio);
    }else{
        $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información");
    }
    
    echo json_encode($respuesta);

    $db = null;
}

if($funcion == 'catCobertura'){

   	$db = conectarMySQL();
    $sql = "Select RIE_clave, RIE_nombre From RiesgoAfectado where RIE_activo = 'S'";
    $result = $db->query($sql);
    $datos = $result->fetchAll();    
    echo json_encode($datos);
    $db = null;
}

if ($funcion == 'validaAut') {
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}

    $autorizacion =123456;
    $datos = json_decode($postdata);
    if($datos->aut==$autorizacion){
        $datosResp=array('respuesta'=>'correcto');
    }
    else{
        $datosResp=array('respuesta'=>'incorrecto');
    }
    echo json_encode($datosResp);
}

if($funcion == 'registraSin'){

    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

     $conexion = conectarMySQL();

    $cobAfec = $datos->cobAfec;
    $inciso = $datos->inciso;
    $noCia = $datos->noCia;
    $poliza = $datos->poliza;
    $siniestro = $datos->siniestro;
    $reporte = $datos->reporte;
    $folPase = $datos->folPase;
    $obs = $datos->obs;


    $sql = "UPDATE Expediente SET Exp_poliza = :Exp_poliza, 
            Exp_siniestro = :Exp_siniestro, 
            Exp_reporte = :Exp_reporte,  
            Exp_RegCompania = :Exp_RegCompania,  
            Exp_obs = :Exp_obs,
            RIE_clave = :RIE_clave,
            Exp_inciso = :Exp_inciso,
            Exp_folPase = :Exp_folPase
            WHERE Exp_folio = :Exp_folio";

            $stmt = $conexion->prepare($sql);                                  
            $stmt->bindParam('Exp_poliza', $poliza);
            $stmt->bindParam('Exp_reporte', $reporte);       
            $stmt->bindParam('Exp_siniestro', $siniestro);    
            $stmt->bindParam('Exp_RegCompania', $noCia);
            // use PARAM_STR although a number  
            $stmt->bindParam('Exp_obs', $obs); 
            $stmt->bindParam('RIE_clave', $cobAfec);   
            $stmt->bindParam('Exp_inciso', $inciso);   
            $stmt->bindParam('Exp_folPase', $folPase);   
            $stmt->bindParam('Exp_folio', $fol);               

    if ($stmt->execute()){
        $respuesta = array('respuesta' =>'correcto','folio'=>$fol);
    }else{
        $respuesta = array('respuesta' =>'incorrecto','folio'=>'');
        }
    echo json_encode($respuesta);

    $conexion = null;    
}

if($funcion == 'getFolio'){
    $db = conectarMySQL();
    $sql = "Select Exp_folio,Expediente.UNI_clave, Exp_nombre, Exp_paterno, Exp_materno, Exp_siniestro, Exp_poliza, Exp_reporte, Exp_fecreg, Expediente.Cia_clave, Usu_registro, Exp_fecreg, USU_registro, Exp_obs, Uni_nombre, Uni_propia, Cia_nombrecorto, RIE_nombre, Exp_RegCompania,
            Pro_clave
            From Expediente inner join Unidad on Expediente.UNI_clave=Unidad.UNI_clave 
            inner join Compania on Expediente.Cia_clave=Compania.Cia_clave
            inner join RiesgoAfectado on Expediente.RIE_clave=RiesgoAfectado.RIE_clave
            where Exp_cancelado=0 and Exp_folio='".$folio."';";
    $result = $db->query($sql);
    $datosFolio = $result->fetch(PDO::FETCH_OBJ);
    echo json_encode($datosFolio);
    $db = null;    
}

if($funcion == 'listadoFolios'){
    $db = conectarMySQL();
    $query="Select Exp_folio, Cia_nombrecorto, Date_Format(Exp_fecreg, '%d-%m-%Y') as Fecha, Exp_paterno, Exp_materno, Exp_nombre, Exp_obs From Expediente inner join Unidad on Expediente.Uni_clave=Unidad.Uni_clave inner join Compania on Expediente.Cia_clave=Compania.Cia_clave Where Exp_cancelado=0 and Expediente.Uni_clave=".$uni." order by Exp_folio desc LIMIT 0 , 30";
    $result = $db->query($query);
    $datosFolio = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($datosFolio);
    $db = null;    
}

if($funcion == 'getDatosPaciente'){
    $db = conectarMySQL();
    $query="Select Exp_folio, Exp_paterno, Exp_materno, Exp_nombre, Exp_fechaNac,Exp_edad,Exp_meses, Exp_sexo, Ocu_clave,Edo_clave,Exp_telefono,Exp_mail, Exp_obs From Expediente  Where Exp_folio='".$folio."'";
    $result = $db->query($query);
    $datosPaciente = $result->fetch(PDO::FETCH_OBJ);
    echo json_encode($datosPaciente);
    $db = null;    
}

if($funcion == 'getOcupacion'){
    $db = conectarMySQL();
    $query="SELECT Ocu_clave, Ocu_nombre FROM Ocupacion";
    $result = $db->query($query);
    $ocupacion = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($ocupacion);
    $db = null;    
}

if($funcion == 'getEdoCivil'){
    $db = conectarMySQL();
    $query="SELECT Edo_clave, Edo_nombre FROM EdoCivil";
    $result = $db->query($query);
    $edoCivil = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($edoCivil);
    $db = null;    
}

if($funcion == 'guardaDatos'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

     $conexion = conectarMySQL();

    $fecNac = $datos->fecnac;
    $anios = $datos->anios;
    $meses = $datos->meses;
    $sexo = $datos->sexo;
    $edoC = $datos->edoC;
    $mail = $datos->mail;
    $obs = $datos->obs;
    $folio = $datos->folio;


    $sql = "UPDATE Expediente SET Exp_fechaNac = :Exp_fechaNac, 
            Exp_edad = :Exp_edad, 
            Exp_meses = :Exp_meses,  
            Exp_sexo = :Exp_sexo,  
            Edo_clave = :Edo_clave,
            Exp_mail = :Exp_mail,
            Exp_obs = :Exp_obs            
            WHERE Exp_folio = :Exp_folio";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam('Exp_fechaNac', $fecNac);                                  
            $stmt->bindParam('Exp_edad', $anios);
            $stmt->bindParam('Exp_meses', $meses);       
            $stmt->bindParam('Exp_sexo', $sexo);    
            $stmt->bindParam('Edo_clave', $edoC);
            // use PARAM_STR although a number  
            $stmt->bindParam('Exp_mail', $mail); 
            $stmt->bindParam('Exp_obs', $obs);           
            $stmt->bindParam('Exp_folio', $folio);               

    if ($stmt->execute()){
        $respuesta = array('respuesta' =>'correcto','folio'=>$fol);
    }else{
        $respuesta = array('respuesta' =>'incorrecto','folio'=>'');
        }
    echo json_encode($respuesta);

    $conexion = null;    
}

if($funcion == 'getEnfermedad'){
    $db = conectarMySQL();
    $query="SELECT Enf_clave, Enf_nombre FROM Enfermedad";
    $result = $db->query($query);
    $edoCivil = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($edoCivil);
    $db = null;    
}

if($funcion == 'getFamiliar'){
    $db = conectarMySQL();
    $query="SELECT Fam_clave, Fam_nombre FROM Familia";
    $result = $db->query($query);
    $edoCivil = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($edoCivil);
    $db = null;    
}

if($funcion == 'getEstatus'){
    $db = conectarMySQL();
    $query="SELECT Est_clave, Est_nombre FROM EstatusFam";
    $result = $db->query($query);
    $edoCivil = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($edoCivil);
    $db = null;    
}

if($funcion == 'getListEnfHeredo'){
    $db = conectarMySQL();
    $query="SELECT FamE_clave, Enf_nombre, Fam_nombre, Est_nombre, FamE_obs 
                               FROM FamEnfermedad 
                               Inner Join Enfermedad on FamEnfermedad.Enf_clave=Enfermedad.Enf_clave 
                               Inner Join Familia on FamEnfermedad.Fam_clave=Familia.Fam_clave 
                               Inner Join EstatusFam on FamEnfermedad.Est_clave=EstatusFam.Est_clave 
                               Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listEnfHeredo = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listEnfHeredo);
    $db = null;    
}

if($funcion == 'guardaEnfH'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $enfermedad = $datos->enfermedad;
    $familiar = $datos->familiar;
    $estatus = $datos->estatus;
    $observaciones = $datos->observaciones;

    $db = conectarMySQL();    

    try{ $query1="Insert into FamEnfermedad(Exp_folio, Enf_clave, Fam_clave, Est_clave, FamE_obs) 
        Values(:Exp_folio,:Enf_clave,:Fam_clave,:Est_clave,:FamE_obs);";

    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);
    $temporal->bindParam("Enf_clave", $enfermedad);
    $temporal->bindParam("Fam_clave", $familiar);
    $temporal->bindParam("Est_clave", $estatus);
    $temporal->bindParam("FamE_obs", $observaciones);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'borraEnfH'){
    $db = conectarMySQL();
    $query="DELETE FROM FamEnfermedad WHERE Exp_folio =  :Exp_folio and FamE_clave = :FamE_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('FamE_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'getPadecimientos'){
    $db = conectarMySQL();
    $query="SELECT Pad_clave, Pad_nombre FROM Padecimientos";
    $result = $db->query($query);
    $padecimientos = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($padecimientos);
    $db = null;    
}

if($funcion == 'getOtrasEnf'){
    $db = conectarMySQL();
    $query="SELECT Otr_clave, Otr_nombre FROM Otras";
    $result = $db->query($query);
    $otrasEnf = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($otrasEnf);
    $db = null;    
}

if($funcion == 'getAlergias'){
    $db = conectarMySQL();
    $query="SELECT Ale_clave, Ale_nombre FROM Alergias";
    $result = $db->query($query);
    $alergias = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($alergias);
    $db = null;    
}

if($funcion == 'getListPadecimientos'){
    $db = conectarMySQL();
    $query="SELECT Hist_clave, Pad_nombre, Pad_obs 
           FROM HistoriaPadecimiento 
           Inner Join Padecimientos on HistoriaPadecimiento.Pad_clave=Padecimientos.Pad_clave 
           Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listPad = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listPad);
    $db = null;    
}

if($funcion == 'getListOtrasEnf'){
    $db = conectarMySQL();
    $query="SELECT HistOt_clave, Otr_nombre, HistOt_obs 
           FROM HistoriaOtras 
           Inner Join Otras on HistoriaOtras.Otr_clave=Otras.Otr_clave 
           Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listOtras = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listOtras);
    $db = null;    
}

if($funcion == 'getListAlergias'){
    $db = conectarMySQL();
    $query="SELECT HistA_clave, Ale_nombre, Ale_obs 
             FROM HistoriaAlergias
             Inner Join Alergias on HistoriaAlergias.Ale_clave=Alergias.Ale_clave 
             Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listAlergias = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listAlergias);
    $db = null;    
}

if($funcion == 'getListPadEsp'){
    $db = conectarMySQL();
    $query="SELECT HistE_clave, Esp_estatus, Esp_obs 
            FROM HistoriaEspalda
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listPadEsp = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listPadEsp);
    $db = null;    
}

if($funcion == 'getListTratQuiro'){
    $db = conectarMySQL();
    $query="SELECT HistoriaQ_clave, Quiro_estatus, Quiro_obs 
            FROM HistoriaQuiro 
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listPadEsp = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listPadEsp);
    $db = null;    
}

if($funcion == 'getListPlantillas'){
    $db = conectarMySQL();
    $query="SELECT HistP_clave, Plantillas_estatus, Plantillas_obs 
            FROM HistoriaPlantillas
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listPadEsp = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listPadEsp);
    $db = null;    
}

if($funcion == 'getListTratamientos'){
    $db = conectarMySQL();
    $query="SELECT HistT_clave, HistT_estatus, HistT_obs 
            FROM HistoriaTrat
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listPadEsp = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listPadEsp);
    $db = null;    
}

if($funcion == 'getListIntervenciones'){
    $db = conectarMySQL();
    $query="SELECT HistO_clave, HistO_estatus, HistO_obs 
                   FROM HistoriaOperacion 
                   Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListDeportes'){
    $db = conectarMySQL();
    $query="SELECT HistD_clave, Dep_estatus, Dep_obs 
            FROM HistoriaDeporte
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListAdicciones'){
    $db = conectarMySQL();
    $query="SELECT HistA_clave, Adic_estatus, Adic_obs 
            FROM HistoriaAdiccion 
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getCatLugar'){
    $db = conectarMySQL();
    $query="SELECT Lug_clave, Lug_nombre FROM LugarRed";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListAccAnt'){
    $db = conectarMySQL();
    $query="SELECT HistAcc_clave, Acc_estatus, Lug_nombre, Acc_obs FROM HistoriaAcc
              Inner Join Lugar on HistoriaAcc.Lug_clave=Lugar.Lug_clave
              Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListPacLlega'){
    $db = conectarMySQL();
    $query="SELECT Llega_clave, Llega_nombre FROM Llega_red";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListTipVehi'){
    $db = conectarMySQL();
    $query="SELECT id, opcion FROM TipoVehiculo_red";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListVitales'){
    $db = conectarMySQL();
    $query="Select Vit_temperatura, Vit_talla, Vit_peso, Vit_ta, Vit_fc, Vit_fr , Vit_imc , Vit_observaciones, Vit_fecha, Usu_registro, IMC_categoria, IMC_comentario From Vitales  Inner Join IMC on IMC.IMC_clave=Vitales.IMC_clave  Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);
    $db = null;    
}

if($funcion == 'getListEmbarazo'){
    $db = conectarMySQL();
    $query="SELECT Emb_semGestacion, Emb_dolAbdominal, Emb_descripcion, Emb_movFetales, Emb_fcf, Emb_ginecologia, Emb_obs FROM Embarazo Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listEmbarazo = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listEmbarazo);
    $db = null;    
}

if($funcion == 'getListLesion'){
    $db = conectarMySQL();
    $query="SELECT LES_clave, LES_nombre FROM LesionRed";
    $result = $db->query($query);
    $listLesion = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listLesion);
    $db = null;    
}

if($funcion == 'getListLesiones'){
    $fol=$_GET['fol'];
    $db = conectarMySQL();
    $query="SELECT Les_nombre, Cue_nombre, LesN_clave FROM LesionNota inner join Lesion on Lesion.Les_clave=LesionNota.Les_clave inner join Cuerpo on Cuerpo.Cue_clave=LesionNota.Cue_clave Where Exp_folio='".$fol."' ORDER BY LesN_clave ASC";
    $result = $db->query($query);
    $listLesiones = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listLesiones);
    $db = null;    
}

if($funcion == 'getListRX'){    
    $db = conectarMySQL();
    $query="SELECT Rx_clave, Rx_nombre FROM Rx";
    $result = $db->query($query);
    $listRx = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listRx);
    $db = null;    
}
if($funcion == 'getListEstSol'){    
    $db = conectarMySQL();
    $query="SELECT Rxs_clave, Rx_nombre, Rxs_Obs, Rxs_desc 
            FROM RxSolicitados inner Join Rx on Rx.Rx_clave=RxSolicitados.Rx_clave 
            Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listEstSol = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listEstSol);
    $db = null;    
}

if($funcion == 'getListProRea'){    
    $db = conectarMySQL();
    $query="SELECT Nproc_clave, Pro_nombre, Nproc_obs  FROM NotaProcedimientos inner Join Procedimientos on Procedimientos.Pro_clave=NotaProcedimientos.Pro_clave Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listProcedimientos = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listProcedimientos);
    $db = null;    
}

if($funcion == 'getListProcedimientos'){    
    $db = conectarMySQL();
    $query="SELECT Pro_clave, Pro_nombre FROM Procedimientos";
    $result = $db->query($query);
    $listProce = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listProce);
    $db = null;    
}

if($funcion == 'getListDiagnostic'){    
    $db = conectarMySQL();
    $query="SELECT * FROM DxComunes";
    $result = $db->query($query);
    $listDiagnostic = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listDiagnostic);
    $db = null;    
}

if($funcion == 'getListMedicamentos'){    
    $db = conectarMySQL();
    $query="SELECT Sum_clave, Sum_nombre, Sum_presentacion, Sum_indicacion  FROM Suministro Where activo=1 and Roma=0 Order by peso desc,Sum_nombre ASC";
    $result = $db->query($query);
    $listDiagnostic = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listDiagnostic);
    $db = null;    
}

if($funcion == 'getListOrtesis'){    
    $db = conectarMySQL();
    $query="SELECT Ort_clave, Ort_nombre FROM Ortesis order by cuadro desc, Ort_nombre";
    $result = $db->query($query);
    $listDiagnostic = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listDiagnostic);
    $db = null;    
}

if($funcion == 'getListIndicaciones'){    
    $db = conectarMySQL();
    $query="SELECT Ind_clave, Ind_nombre FROM IndicacionesGenerales";
    $result = $db->query($query);
    $listDiagnostic = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listDiagnostic);
    $db = null;    
}

if($funcion == 'getListMedicamentosAgreg'){    
    $db = conectarMySQL();
    $query="SELECT Nsum_clave, Sum_nombre, Nsum_obs, Nsum_Cantidad  FROM NotaSuministro inner Join Suministro on Suministro.Sum_clave =NotaSuministro.Sum_clave Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listMediAgre = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listMediAgre);
    $db = null;    
}

if($funcion == 'getListOrtesisAgreg'){    
    $db = conectarMySQL();
    $query="SELECT Notor_clave, Ort_nombre, Ortpre_nombre, Notor_cantidad, Notor_indicaciones FROM NotaOrtesis inner Join Ortesis on Ortesis.Ort_clave=NotaOrtesis.Ort_clave inner Join  Ortpresentacion on Ortpresentacion.Ortpre_clave=NotaOrtesis.Ortpre_clave Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listMediAgre = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listMediAgre);
    $db = null;    
}
if($funcion == 'getListIndicAgreg'){    
    $db = conectarMySQL();
    $query="SELECT Nind_clave, Nind_obs FROM NotaInd Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $listMediAgre = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listMediAgre);
    $db = null;    
}

if($funcion == 'vePosologia'){    
    $db = conectarMySQL();
    $query="SELECT Sum_indicacion  FROM Suministro Where Sum_clave =".$cveMed;
    $result = $db->query($query);
    $posologia = $result->fetch(PDO::FETCH_OBJ);
    echo json_encode($posologia);
    $db = null;    
}

if($funcion == 'veIndicacion'){    
    $db = conectarMySQL();
    $query="SELECT Sum_indicacion  FROM Suministro Where Sum_clave =".$cveMed;
    $result = $db->query($query);
    $posologia = $result->fetch(PDO::FETCH_OBJ);
    echo json_encode($posologia);
    $db = null;    
}

if($funcion == 'veIndicacion'){    
    $db = conectarMySQL();
    $query="SELECT Sum_indicacion  FROM Suministro Where Sum_clave =".$cveMed;
    $result = $db->query($query);
    $posologia = $result->fetch(PDO::FETCH_OBJ);
    echo json_encode($posologia);
    $db = null;    
}

if($funcion == 'selectPosicion'){
    $db = conectarMySQL();
    $query="SELECT id, opcion FROM PosicionAcc WHERE relacion=".$opcion;
    $result = $db->query($query);
    $listInter = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($listInter);   
    $db = null;    
}

if($funcion == 'guardaPad'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $padecimiento = $datos->nombre;
    $obs = $datos->obs;

    $db = conectarMySQL();
    
    try{ 
        $query1="Insert into HistoriaPadecimiento(Exp_folio, Pad_clave, Pad_obs) 
                              Values(:Exp_folio,:Pad_clave,:Pad_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);
    $temporal->bindParam("Pad_clave", $padecimiento);
    $temporal->bindParam("Pad_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'borraPadec'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaPadecimiento WHERE Exp_folio = :Exp_folio and Hist_clave = :Hist_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('Hist_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaOtras'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $enfermedad = $datos->enf;
    $obs = $datos->obs;

    $db = conectarMySQL();
    try{ 
        $query1="Insert into HistoriaOtras(Exp_folio, Otr_clave, HistOt_obs) 
                                 Values(:Exp_folio,:Otr_clave,:HistOt_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);
    $temporal->bindParam("Otr_clave", $enfermedad);
    $temporal->bindParam("HistOt_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'borraOtrasEnf'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaOtras WHERE Exp_folio = :Exp_folio and HistOt_clave = :HistOt_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistOt_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaAlergia'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);

    $alergia = $datos->alergia;
    $obs = $datos->obs;

    $db = conectarMySQL();
    try{ 
        $query1="Insert into HistoriaAlergias(Exp_folio, Ale_clave, Ale_obs) 
                                 Values(:Exp_folio,:Ale_clave,:Ale_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);
    $temporal->bindParam("Ale_clave", $alergia);
    $temporal->bindParam("Ale_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;    
}


if($funcion == 'borraAlergia'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaAlergias WHERE Exp_folio = :Exp_folio and HistA_clave = :HistA_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistA_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaPadEspalda'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;

    $db = conectarMySQL();
    
    try{ 
        $query1="Insert into HistoriaEspalda(Exp_folio, Esp_estatus, Esp_obs) 
                           Values(:Exp_folio,'S',:Esp_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("Esp_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'borraPadEspalda'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaEspalda WHERE Exp_folio = :Exp_folio and HistE_clave = :HistE_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistE_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaTratQuiro'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;

    $db = conectarMySQL();

    try{ 
        $query1="Insert into HistoriaQuiro(Exp_folio, Quiro_estatus, Quiro_obs) 
                              Values(:Exp_folio,'S',:Quiro_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("Quiro_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'borraTratQui'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaQuiro WHERE Exp_folio = :Exp_folio and HistoriaQ_clave = :HistoriaQ_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistoriaQ_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaPlantillas'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;

    $db = conectarMySQL();

    try{ 
        $query1="Insert into HistoriaPlantillas(Exp_folio, Plantillas_estatus, Plantillas_obs) 
                           Values(:Exp_folio,'S',:Plantillas_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("Plantillas_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'borraPlatillas'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaPlantillas WHERE Exp_folio = :Exp_folio and HistP_clave = :HistP_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistP_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaTratamiento'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;
    $db = conectarMySQL();
    try{ 
        $query1="Insert into HistoriaTrat(Exp_folio, HistT_estatus, HistT_obs) 
                           Values(:Exp_folio,'S',:HistT_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("HistT_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'borraTratamiento'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaTrat WHERE Exp_folio = :Exp_folio and HistT_clave = :HistT_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistT_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaIntervenciones'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;

    $db = conectarMySQL();
    try{ 
        $query1="Insert into HistoriaOperacion(Exp_folio, HistO_estatus, HistO_obs) 
                 Values(:Exp_folio,'S',:HistO_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("HistO_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'borraIntervencion'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaOperacion WHERE Exp_folio = :Exp_folio and HistO_clave = :HistO_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistO_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaDeporte'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;

    $db = conectarMySQL();
    try{ 
        $query1="Insert into HistoriaDeporte(Exp_folio, Dep_estatus, Dep_obs) 
                   Values(:Exp_folio,'S',:Dep_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("Dep_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'borraDeporte'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaDeporte WHERE Exp_folio = :Exp_folio and HistD_clave = :HistD_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistD_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaAdiccion'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
   
    $obs = $datos->obs;

    $db = conectarMySQL();

    try{ 
        $query1="Insert into HistoriaAdiccion(Exp_folio, Adic_estatus, Adic_obs) 
                   Values(:Exp_folio,'S',:Adic_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("Adic_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'borraAdiccion'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaAdiccion WHERE Exp_folio = :Exp_folio and HistA_clave = :HistA_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistA_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaAccAnt'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
    
    $opc=   $datos->opc;
    $lugar  =$datos->lugar;
    $obs = $datos->obs;

    $db = conectarMySQL();

    try{ 
        $query1="Insert into HistoriaAcc(Exp_folio, Acc_estatus, Lug_clave, Acc_obs)
                                 Values(:Exp_folio,:Acc_estatus,:Lug_clave,:Acc_obs);";
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Exp_folio", $fol);   
    $temporal->bindParam("Acc_estatus", $opc);   
    $temporal->bindParam("Lug_clave", $lugar);   
    $temporal->bindParam("Acc_obs", $obs);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'borraAccAnt'){
    $db = conectarMySQL();
    $query="DELETE FROM HistoriaAcc WHERE Exp_folio = :Exp_folio and HistAcc_clave = :HistAcc_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('HistAcc_clave', $cont);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion == 'guardaVitales'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $db = conectarMySQL();    

    $tem        =$datos->tem;
    $talla      =$datos->talla;
    $peso       =$datos->peso;
    $frecResp   =$datos->frecResp;
    $frecCard   =$datos->frecCard;
    $TenArt     =$datos->sistole;
    $obs        =$datos->obs;

    try{ 
        
        $query="SELECT * FROM Nota_med_red where Exp_folio='".$fol."'";
        $result = $db->query($query);
        $vitales = $result->fetch();
        if($vitales){
            $query1="UPDATE Nota_med_red SET Not_temperatura=:Not_temperatura,Not_talla=:Not_talla,Not_peso=:Not_peso,Not_fr=:Not_fr,Not_fc=:Not_fc,Not_ta=:Not_ta,Not_obs_vitales=:Not_obs_vitales
                where Exp_folio=:Exp_folio";   
        }else{
            $query1="INSERT INTO Nota_med_red (Not_temperatura,Not_talla,Not_peso,Not_fr,Not_fc,Not_ta,Not_obs_vitales,Exp_folio)
                 VALUES(:Not_temperatura,:Not_talla,:Not_peso,:Not_fr,:Not_fc,:Not_ta,:Not_obs_vitales,:Exp_folio)";             
        }
    $temporal = $db->prepare($query1);
    $temporal->bindParam("Not_temperatura", $tem);
    $temporal->bindParam("Not_talla", $talla);   
    $temporal->bindParam("Not_peso", $peso);   
    $temporal->bindParam("Not_fr", $frecResp);   
    $temporal->bindParam("Not_fc", $frecCard);
    $temporal->bindParam("Not_ta", $TenArt);
    $temporal->bindParam("Not_obs_vitales", $obs);
     $temporal->bindParam("Exp_folio", $fol);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'guardaVitalesP'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $db = conectarMySQL();    

    $tem        =$datos->tem;
    $talla      =$datos->talla;
    $peso       =$datos->peso;
    $frecResp   =$datos->frecResp;
    $frecCard   =$datos->frecCard;
    $sistole    =$datos->sistole;
    $astole     =$datos->astole;
    $obs        =$datos->obs;

    $TenArt= $sistole."/".$astole;

    $imc= $ps/(($talla/100)*($talla/100));
    $imc= number_format($imc,2);
    if($imc<16.00)                 $indice=1;
    if($imc>=16.00 && $imc<=16.99) $indice=2;
    if($imc>=17.00 && $imc<=18.49) $indice=3;
    if($imc>=18.50 && $imc<=24.99) $indice=4;
    if($imc>=25.00 && $imc<=29.99) $indice=5;
    if($imc>=30.00 && $imc<=34.99) $indice=6;
    if($imc>=35.00 && $imc<=39.99) $indice=7;
    if($imc>=40.00 && $imc<=44.99) $indice=8;
    if($imc>=45.00)                $indice=9;

    try{ 
        
        $query="Insert into Vitales (Exp_folio, Vit_temperatura, Vit_talla, Vit_peso, Vit_ta, Vit_fc, Vit_fr, Vit_imc , IMC_clave, Vit_observaciones, Vit_fecha, Usu_registro)
                    values(:Exp_folio, :Vit_temperatura,:Vit_talla,:Vit_peso,:Vit_ta,:Vit_fc,:Vit_fr,:Vit_imc,:IMC_clave,:Vit_observaciones,now(),:Usu_registro)";
        
    $temporal = $db->prepare($query);
    $temporal->bindParam("Vit_temperatura", $tem);
    $temporal->bindParam("Vit_talla", $talla);   
    $temporal->bindParam("Vit_peso", $peso);   
    $temporal->bindParam("Vit_fr", $frecResp);   
    $temporal->bindParam("Vit_fc", $frecCard);
    $temporal->bindParam("Vit_ta", $TenArt);
    $temporal->bindParam("Vit_imc", $imc);
    $temporal->bindParam("IMC_clave", $indice);
    $temporal->bindParam("Vit_observaciones", $obs);
    $temporal->bindParam("Usu_registro", $usr);
     $temporal->bindParam("Exp_folio", $fol);

    if ($temporal->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;   
} 

if($funcion == 'guardaDatAcc'){
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    //En este caso lo que mando es este objeto JSON {user:username,psw:password}
    $datos = json_decode($postdata);
    $db = conectarMySQL();    

    $cefalea        =$datos->cefalea;
    $conocimiento   =$datos->conocimiento;
    $fecha          =$datos->fecha;
    $llega          =$datos->llega;
    $mareo          =$datos->mareo;
    $mecLesion      =$datos->mecLesion;
    $mecanismo      =$datos->mecanismo;
    $nauseas        =$datos->nauseas;
    $posicion       =$datos->posicion;
    $seguridad      =$datos->seguridad;
    $vehiculo       =$datos->vehiculo;
    $vomito         =$datos->vomido;

    $stringMecanismo='';
    $stringSeguridad='';
    
    try{ 
        $query= "Select * From NotaMedica Where Exp_folio='".$fol."'";
        $result = $db->query($query);
        $nota = $result->fetch();
        if($nota){
            $query="UPDATE NotaMedica SET Llega_clave = :Llega_clave, 
                    Not_fechaAcc = :Not_fechaAcc, 
                    TipoVehiculo_clave = :TipoVehiculo_clave, 
                    Posicion_clave = :Posicion_clave,                        
                    Not_obs = :Not_obs 
            WHERE  Exp_folio = :Exp_folio;";  

            $temporal = $db->prepare($query);
            $temporal->bindParam("Llega_clave", $llega);
            $temporal->bindParam("Not_fechaAcc", $fecha);   
            $temporal->bindParam("TipoVehiculo_clave", $vehiculo);   
            $temporal->bindParam("Posicion_clave", $posicion);              
            $temporal->bindParam("Not_obs", $mecLesion);
            $temporal->bindParam("Exp_folio", $fol);     

            if ($temporal->execute()){ 
                    $n=count($seguridad);
                for($i=0; $i<$n; $i++){
                    if ($seguridad[$i] != "" || $seguridad[$i] != 0){
                        $query="Insert into SegNotaMed(Exp_folio, Not_clave, Equi_clave)
                                   Values(:Exp_folio,1,:Equi_clave)";
                        $temporal = $db->prepare($query);
                        $temporal->bindParam("Exp_folio", $fol);
                        $temporal->bindParam("Equi_clave", $seguridad[$i]);   
                        $temporal->execute();
                    }
                }
                $n=count($mecanismo);
                for($i=0; $i<$n; $i++){
                    if($mecanismo[$i] !="" || $mecanismo[$i]!= 0){
                        $query="Insert into MecNotaMed(Exp_folio, Not_clave, Mec_clave)
                                    Values(:Exp_folio,1,:Mec_clave)";
                        $temporal = $db->prepare($query);
                        $temporal->bindParam("Exp_folio", $fol);
                        $temporal->bindParam("Mec_clave", $mecanismo[$i]);   
                        $temporal->execute();
                    }
                }       
                    $query="SELECT Exp_sexo FROM Expediente WHERE Exp_cancelado=0 and Exp_folio='".$fol."'";
                    $result = $db->query($query);
                    $sexo = $result->fetch();
                    $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol,'sexo'=> $sexo['Exp_sexo']);            

            
            }else{
                $respuesta = array('respuesta' => 'incorrecto');
            }
                  
        }else{
            $query="Insert into NotaMedica(Exp_folio, Llega_clave, Not_fechaAcc, TipoVehiculo_clave, Posicion_clave, Not_vomito,Not_mareo,Not_nauseas, Not_perdioConocimiento, Not_cefalea, Not_obs, Usu_nombre, Not_fechareg)
                            Values(:Exp_folio,:Llega_clave,:Not_fechaAcc,:TipoVehiculo_clave,:Posicion_clave,:Not_vomito,:Not_mareo,:Not_nauseas,:Not_perdioConocimiento,:Not_cefalea,:Not_obs,:Usu_nombre,now())";    

            $temporal = $db->prepare($query);
            $temporal->bindParam("Llega_clave", $llega);
            $temporal->bindParam("Not_fechaAcc", $fecha);   
            $temporal->bindParam("TipoVehiculo_clave", $vehiculo);   
            $temporal->bindParam("Posicion_clave", $posicion);   
            $temporal->bindParam("Not_vomito", $vomito);
            $temporal->bindParam("Not_mareo", $mareo);
            $temporal->bindParam("Not_nauseas", $nauseas);
            $temporal->bindParam("Not_perdioConocimiento", $conocimiento);
            $temporal->bindParam("Not_cefalea", $cefalea);
            $temporal->bindParam("Not_obs", $mecLesion);
            $temporal->bindParam("Usu_nombre", $usr);
            $temporal->bindParam("Exp_folio", $fol);

            if ($temporal->execute()){ 
                $n=count($seguridad);
                for($i=0; $i<$n; $i++){
                    if ($seguridad[$i] != "" || $seguridad[$i] != 0){
                        $query="Insert into SegNotaMed(Exp_folio, Not_clave, Equi_clave)
                                   Values(:Exp_folio,1,:Equi_clave)";
                        $temporal = $db->prepare($query);
                        $temporal->bindParam("Exp_folio", $fol);
                        $temporal->bindParam("Equi_clave", $seguridad[$i]);   
                        $temporal->execute();
                    }
                }
                $n=count($mecanismo);
                for($i=0; $i<$n; $i++){
                    if($mecanismo[$i] !="" || $mecanismo[$i]!= 0){
                        $query="Insert into MecNotaMed(Exp_folio, Not_clave, Mec_clave)
                                    Values(:Exp_folio,1,:Mec_clave)";
                        $temporal = $db->prepare($query);
                        $temporal->bindParam("Exp_folio", $fol);
                        $temporal->bindParam("Mec_clave", $mecanismo[$i]);   
                        $temporal->execute();
                    }
                }
                $query="SELECT Exp_sexo FROM Expediente WHERE Exp_cancelado=0 and Exp_folio='".$fol."'";
                $result = $db->query($query);
                $sexo = $result->fetch();
                $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol,'sexo'=> $sexo['Exp_sexo']);
            }else{
                $respuesta = array('respuesta' => 'incorrecto');
            }
        }
        
}catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
} 

if($funcion=='guardaEmbarazo'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);

    $controlGine        =$datos->controlGine;
    $desc      =$datos->desc;
    $dolor       =$datos->dolor;
    $fcFet   =$datos->fcFet;
    $justif   =$datos->justif;
    $movFet    =$datos->movFet;
    $semanas     =$datos->semanas;    
    $db = conectarMySQL(); 
    try{
    $query="Select Exp_folio From Embarazo Where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $embarazo = $result->fetch();
    $folioEmb=$embarazo['Exp_folio'];
    if($folioEmb==""|| $folioEmb==null){
        $query="Insert into Embarazo(Exp_folio, Emb_semGestacion, Emb_dolAbdominal, Emb_descripcion, Emb_fcf, Emb_movFetales, Emb_ginecologia, Emb_obs)
                         Values(:Exp_folio,:Emb_semGestacion,:Emb_dolAbdominal,:Emb_descripcion,:Emb_fcf,:Emb_movFetales,:Emb_ginecologia,:Emb_obs)";
        $temporal = $db->prepare($query);
        $temporal->bindParam("Exp_folio", $fol);
        $temporal->bindParam("Emb_semGestacion", $semanas);  
        $temporal->bindParam("Emb_dolAbdominal", $dolor);  
        $temporal->bindParam("Emb_descripcion", $desc);  
        $temporal->bindParam("Emb_fcf", $fcFet);  
        $temporal->bindParam("Emb_movFetales", $movFet);  
        $temporal->bindParam("Emb_ginecologia", $controlGine);  
        $temporal->bindParam("Emb_obs", $justif); 
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }
    }else{
        $respuesta = array('respuesta' => 'lleno');
    }
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion=='guardaLesion'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $cuerpo        =$datos->cuerpo;
    $lesion      =$datos->lesion;   
    $db = conectarMySQL(); 
    try{    
        $query="Insert into LesionNota(Exp_folio, Les_clave, Cue_clave)
                       Values(:Exp_folio,:Les_clave,:Cue_clave)";
        $temporal = $db->prepare($query);
        $temporal->bindParam("Exp_folio", $fol);
        $temporal->bindParam("Les_clave", $lesion);  
        $temporal->bindParam("Cue_clave", $cuerpo);         
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion == 'eliminaLesion'){
    $db = conectarMySQL();
    $query="DELETE FROM LesionNota WHERE Exp_folio = :Exp_folio and LesN_clave = :LesN_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Exp_folio', $fol);
    $stmt->bindParam('LesN_clave', $cveLes);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion=='guardaEdoGral'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $estado        =$datos->estado;   
    $db = conectarMySQL(); 
    $query= "select * from ObsNotaMed where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $edoGral = $result->fetch();
    try{    
        if($edoGral){
            $query="UPDATE ObsNotaMed SET ObsNot_edoG=:ObsNot_edoG WHERE Exp_folio=:Exp_folio";                        
        }else{
            $query="INSERT INTO  ObsNotaMed( ObsNot_edoG,Exp_folio)
                             Values(:ObsNot_edoG,:Exp_folio)";                       
        }
        $temporal = $db->prepare($query);
        $temporal->bindParam("Exp_folio", $fol);
        $temporal->bindParam("ObsNot_edoG", $estado);          
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}
if($funcion=='guardaEstudios'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $rx         =$datos->rx;
    $obs        =$datos->obs;
    $interp     =$datos->interp;
    $db = conectarMySQL(); 
    $query= "select * from ObsNotaMed where Exp_folio='".$fol."'";
    $result = $db->query($query);
    $edoGral = $result->fetch();
    try{    
       
            $query="Insert into RxSolicitados(Exp_folio, Rx_clave, Rxs_Obs, Rxs_desc, Usu_solicita, Fecha_solicita, Estatus_rx, Uni_clave, Rxs_desde)
                          Values(:Exp_folio,:Rx_clave,:Rxs_Obs,:Rxs_desc,:Usu_solicita,now(),'PENDIENTE',:Uni_clave,'NOTA MEDICA')";                               
        $temporal = $db->prepare($query);
        $temporal->bindParam("Exp_folio", $fol);
        $temporal->bindParam("Rx_clave", $rx);
        $temporal->bindParam("Rxs_Obs", $obs); 
        $temporal->bindParam("Rxs_desc", $interp);  
        $temporal->bindParam("Usu_solicita", $usr); 
        $temporal->bindParam("Uni_clave", $uniClave);             
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion == 'eliminaEstRealizado'){
    $db = conectarMySQL();
    $query="Delete from RxSolicitados where Rxs_clave = :Rxs_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Rxs_clave', $cveEst);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion=='guardaProcedimientos'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $procedimiento         =$datos->procedimiento;
    $obs        =$datos->obs;   
    $db = conectarMySQL(); 
    try{    
       
            $query="Insert into NotaProcedimientos(Exp_folio, Pro_clave, Nproc_obs)
                                         Values(:Exp_folio,:Pro_clave,:Nproc_obs)";                               
        $temporal = $db->prepare($query);
        $temporal->bindParam("Exp_folio", $fol);
        $temporal->bindParam("Pro_clave", $procedimiento);
        $temporal->bindParam("Nproc_obs", $obs);                 
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion=='guardaDiagnostico'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $diagnostico         =$datos->diagnostico;
    $obs        =$datos->obs;   
    $db = conectarMySQL(); 
    try{    
       
            $query="Update ObsNotaMed Set ObsNot_diagnosticoRx=:ObsNot_diagnosticoRx,ObsNot_obs=:ObsNot_obs WHERE Exp_folio=:Exp_folio";                               
            $temporal = $db->prepare($query);
            $temporal->bindParam("Exp_folio", $fol);
            $temporal->bindParam("ObsNot_diagnosticoRx", $diagnostico);
            $temporal->bindParam("ObsNot_obs", $obs);                 
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion == 'eliminaProcedimiento'){
    $db = conectarMySQL();
    $query="Delete from NotaProcedimientos where Nproc_clave = :Nproc_clave";
    $stmt = $db->prepare($query);
    $stmt->bindParam('Nproc_clave', $proClave);
    if ($stmt->execute()){
        $respuesta = array('respuesta' => 'correcto','pro-clave'=>$proClave);
    }else{
        $respuesta = array('respuesta' => 'incorrecto');
    }
    echo json_encode($respuesta);
    $db = null;    
}

if($funcion=='guardaMedicamento'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $medica         =$datos->medica;
    $posologia        =$datos->posologia; 
    $cantidad        =$datos->cantidad;       
    $db = conectarMySQL(); 
    try{    
       
            $query="Insert into NotaSuministro(Exp_folio, Sum_clave, Nsum_obs, Nsum_Cantidad, Nsum_fecha)
                             Values(:Exp_folio,:Sum_clave,:Nsum_obs,:Nsum_Cantidad,now())";
            $temporal = $db->prepare($query);
            $temporal->bindParam("Exp_folio", $fol);
            $temporal->bindParam("Sum_clave", $medica);
            $temporal->bindParam("Nsum_obs", $posologia);
            $temporal->bindParam("Nsum_Cantidad", $cantidad);                 
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion=='guardaOrtesis'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $ortesis         =$datos->ortesis;
    $presentacion        =$datos->presentacion; 
    $cantidad        =$datos->cantidad; 
    $indicaciones        =$datos->indicaciones;       
    $db = conectarMySQL(); 
    try{    
       
            $query="Insert into NotaOrtesis(Exp_folio, Ort_clave, Ortpre_clave, Notor_cantidad, Notor_indicaciones)
                             Values(:Exp_folio,:Ort_clave,:Ortpre_clave,:Notor_cantidad,:Notor_indicaciones)";
            $temporal = $db->prepare($query);
            $temporal->bindParam("Exp_folio", $fol);
            $temporal->bindParam("Ort_clave", $ortesis);
            $temporal->bindParam("Ortpre_clave", $presentacion);
            $temporal->bindParam("Notor_cantidad", $cantidad);                 
            $temporal->bindParam("Notor_indicaciones", $indicaciones);                 
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion=='guardaIndicacion'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $indicacion         =$datos->indicacion;
    $obs        =$datos->obs;     
    $db = conectarMySQL(); 
    try{    
       
            $query="Insert into NotaInd(Exp_folio, Ind_clave, Nind_obs)
                         Values(:Exp_folio,:Ind_clave,:Nind_obs)";
            $temporal = $db->prepare($query);
            $temporal->bindParam("Exp_folio", $fol);
            $temporal->bindParam("Ind_clave", $indicacion);
            $temporal->bindParam("Nind_obs", $obs);                
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}

if($funcion=='guardaPronostico'){
    $postdata = file_get_contents("php://input");
    $datos = json_decode($postdata);
    $pronostico         =$datos->pronostico;
    $criterio        =$datos->criterio;     
    $db = conectarMySQL(); 
    try{    
       
            $query=" Update ObsNotaMed Set ObsNot_pron=:ObsNot_pron, ObsNot_waddell=:ObsNot_waddell Where Exp_folio=:Exp_folio";
            $temporal = $db->prepare($query);
            $temporal->bindParam("Exp_folio", $fol);
            $temporal->bindParam("ObsNot_pron", $pronostico);
            $temporal->bindParam("ObsNot_waddell", $criterio);                
         if ($temporal->execute()){
            $respuesta = array('respuesta' => 'correcto', 'folio'=>$fol);
        }else{
            $respuesta = array('respuesta' => 'incorrecto');
        }    
    }catch(Exception $e){
    $respuesta=  array('respuesta' => $e->getMessage() );
}
    echo json_encode($respuesta);
    $db = null;  
}
// Solicitudes api

$unidad = $_REQUEST['uniClave'];


if($funcion == 'ActualizaSolicitud'){
    
    $clave = $_REQUEST['clave'];
    $estatus = $_REQUEST['estatus'];

    $conexion = conectarMySQL();

    $sql = "UPDATE Solicitudes SET SOL_estatus = $estatus , SOL_fechaActualiza = now()
            WHERE SOL_claveint = '$clave' ";

    if($conexion->query($sql)){
      $respuesta = array('respuesta' => 'Solicitud actualizada correctamente' );
    }else{
      $respuesta = array('respuesta' => 'Error al momento de actualizar intente nuevamente' );
    }
    
    echo json_encode($respuesta);

    $conexion = null;

}


if($funcion == 'loginfast'){
    
    $user = $_REQUEST['usuario'];
 
    $conexion = conectarMySQL();
        
    //Obtenemos los valores de usuario y contraseña 
    
    $sql = "SELECT * FROM Usuario
            WHERE Usu_login = '$user'";

    $result = $conexion->query($sql);
    $numero = $result->rowCount();
    
    if ($numero > 0){

        $datos = $result->fetchAll(PDO::FETCH_OBJ);
        
    }else{

        $datos = array('respuesta' => 'El Usuario es inorrecto');
    }
    
    echo json_encode($datos);

    $conexion = null;

}


if($funcion == 'busquedaExpedientes'){

    $db = conectarMySQL();
        
    $sql = "SELECT Exp_folio as expediente, Cia_nombrecorto as cliente, Exp_completo as lesionado, Exp_fecreg as fecha, Exp_sexo as sexo, Expediente.Cia_clave as idcliente FROM Expediente
            INNER JOIN Compania on Compania.Cia_clave = Expediente.Cia_clave  WHERE Exp_cancelado = 0 and Uni_clave = $unidad order by Exp_fecreg DESC LIMIT 0,50";

    $result = $db->query($sql);
    $folios = $result->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($folios);

};

if($funcion == 'busquedaFolio'){

    $folio = $_REQUEST['folio'];

    $db = conectarMySQL();
        
    $sql = "SELECT Exp_folio as expediente, Cia_nombrecorto as cliente, Exp_completo as lesionado, Exp_fecreg as fecha, Exp_sexo as sexo, Expediente.Cia_clave as idcliente FROM Expediente
            INNER JOIN Compania on Compania.Cia_clave = Expediente.Cia_clave 
            WHERE EXP_folio = '$folio' and Uni_clave = $unidad ";

    $result = $db->query($sql);
    $folios = $result->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($folios);

};

if($funcion == 'busquedaLesionado'){

    $lesionado = $_REQUEST['lesionado'];

    $db = conectarMySQL();
        
    $sql = "SELECT Exp_folio as expediente, Cia_nombrecorto as cliente, Exp_completo as lesionado, Exp_fecreg as fecha, Exp_sexo as sexo, Expediente.Cia_clave as idcliente FROM Expediente
            INNER JOIN Compania on Compania.Cia_clave = Expediente.Cia_clave 
            WHERE EXP_completo like '% $lesionado %' AND Exp_cancelado = 0 and Uni_clave = $unidad order by EXP_completo limit 0,50";

    $result = $db->query($sql);
    $folios = $result->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    echo json_encode($folios);

};




if($funcion == 'busquedaSolicitudes'){


    $db = conectarMySQL();
        
    $sql = "SELECT Exp_folio as expediente, Cia_nombrecorto as cliente, Exp_completo as lesionado, Exp_fecreg as fecha, Exp_sexo as sexo, Expediente.Cia_clave as idcliente FROM Expediente
            INNER JOIN Compania on Compania.Cia_clave = Expediente.Cia_clave 
            WHERE EXP_folio = '$folio' and Uni_clave = $unidad ";

    $result = $db->query($sql);
    $folios = $result->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($folios);

};


if($funcion == 'detalleSolicitud'){
    
    $clave = $_REQUEST['clave'];
    $archivo = array();
    $archivos = array();

    $conexion = conectarMySQL();

    $sql = "SELECT Exp_folio as folio, SOL_lesionado as lesionado, Cia_nombrecorto as cliente, Solicitudes.TIM_claveint as tipo ,
            TIM_nombreE as tiponombre, DetalleSolicitud.* FROM Solicitudes 
            INNER JOIN DetalleSolicitud ON DetalleSolicitud.SOL_claveint = Solicitudes.SOL_claveint
            LEFT JOIN Compania on Compania.Cia_clave = Solicitudes.Cia_clave
            LEFT JOIN TipoMovimiento ON TipoMovimiento.TIM_claveint = Solicitudes.TIM_claveint
            WHERE Solicitudes.SOL_claveint = '$clave'";

    $result = $conexion->query($sql);

    $datos = $result->fetch(PDO::FETCH_OBJ);


    $sql2 = "SELECT * FROM ArchivosSolicitud
            WHERE SOL_claveint = '$clave'";

    $result = $conexion->query($sql2);

    foreach ($result as $value) {
        
        $nombre = $value['ARS_nombre'];
        $archivo['nombre'] = $nombre;

        if (strstr($nombre, '.pdf')) {
          $archivo['ruta'] = "imgs/pdf.png";
        }elseif (strstr($nombre, '.doc') || strstr($nombre, '.docx') || strstr($nombre, '.xls') || strstr($nombre, '.xlsx') ){
          $archivo['ruta'] = "imgs/office.png";
        }else{
          $archivo['ruta'] = $value['ARS_ruta'];       
        }

        $archivo['ubicacion'] = $value['ARS_ruta'];

        array_push($archivos, $archivo);

    }

    $respuesta = array('info' => $datos, 'archivos' => $archivos);

    echo json_encode($respuesta);

    $conexion = null;

}

if($funcion == 'guardaSolicitud'){

    $db = conectarMySQL();
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    $datos = json_decode($postdata);


    //datos de folio
    $usuario = $datos->usuario;
    $folio = $datos->folio;
    $lesionado = $datos->lesionado;
    $tipo = $datos->tipo;
    $cliente = $datos->cliente;

    $diagnostico = $datos->diagnostico;
    $justificacion = $datos->justificacion;
    
    //interconsulta
    $consultatipo = $datos->interconsulta->tipo;
    $embarazo = $datos->interconsulta->embarazo;
    $controlgineco = $datos->interconsulta->controlgineco;
    $semanas = $datos->interconsulta->semanas;
    $dolorabdominal = $datos->interconsulta->dolorabdominal;
    $frecuencia = $datos->interconsulta->frecuencia;
    $movimientosfetales = $datos->interconsulta->movimientosfetales;
    $consultaObs = $datos->interconsulta->observaciones;

    //estudio especial
    $estudiotipo = $datos->estudio->tipo;
    $estudiodetalle = $datos->estudio->detalle;

    //rehabilitacion

    $dolor = $datos->rehabilitacion->dolor;
    $rehabilitaciones = $datos->rehabilitacion->rehabilitaciones;
    $mejora = $datos->rehabilitacion->mejora;

    //suministro

    $suministrodetalle = $datos->suministro->detalle;

    //informacion
    $notamedica = $datos->informacion->notamedica;
    $rx = $datos->informacion->rx;
    $resultados = $datos->informacion->resultados;
    $infodetalle = $datos->informacion->detalle;

    //salida de paquete

    $hospitalarioDetalle = $datos->salidapaquete->detalle;

    //problema documental

    $pase = $datos->problemadocumental->pase;
    $identificacion = $datos->problemadocumental->identificacion;
    $docdetalle = $datos->problemadocumental->detalle;


    $primera = substr ($lesionado,0, 1); 
    $ultima = substr ($lesionado,-1, 1); 

    $clave = 'S'. $primera . $ultima . generar_numero();
    //$clave = generar_clave();

    $archivos = $datos->soporte;

     if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{
        
        $sql = "INSERT INTO Solicitudes
              (
                     SOL_claveint,
                     TIM_claveint,
                     Exp_folio,
                     SOL_lesionado,
                     SOL_estatus,
                     SOL_fechaReg,
                     SOL_fechaActualiza,
                     Usu_login,
                     Cia_clave                    
              ) 
              VALUES
              (
                    :clave,
                    :tipo,
                    :folio,
                    :lesionado,
                    1,
                    now(),
                    now(),
                    :usuario,
                    :cliente
              )";
        
        $temporal = $db->prepare($sql);
        $temporal->bindParam("clave", $clave, PDO::PARAM_STR);
        $temporal->bindParam("lesionado", $lesionado, PDO::PARAM_STR);
        $temporal->bindParam("folio", $folio, PDO::PARAM_STR, 10);
        $temporal->bindParam("tipo", $tipo, PDO::PARAM_INT);
        $temporal->bindParam("usuario", $usuario, PDO::PARAM_STR);
        $temporal->bindParam("cliente", $cliente, PDO::PARAM_INT);
        
        if ($temporal->execute()){ 

            $sql2 = "INSERT INTO DetalleSolicitud
                  (
                         SOL_claveint,
                         DES_diagnostico,
                         DES_justificacion,
                         DES_intertipo,
                         DES_embarazo,
                         DES_controlgineco,
                         DES_semanas,   
                         DES_dolorabdominal,
                         DES_frecuencia,
                         DES_movimientosfetales,
                         DES_embarazoObs,
                         DES_estudiotipo,
                         DES_estudioDetalle,
                         DES_dolor,
                         DES_rehabilitaciones,
                         DES_mejora,
                         DES_suministroDetalle,
                         DES_notamedica,
                         DES_rx,
                         DES_resultados,
                         DES_infoDetalle,
                         DES_hosDetalle,
                         DES_pase,
                         DES_identificacion,
                         DES_documentalDetalle             
                  ) 
                  VALUES
                  (     
                        :clave,
                        :diagnostico,
                        :justificacion,
                        :consultatipo,
                        :embarazo,
                        :controlgineco,
                        :semanas,
                        :dolorabdominal,
                        :frecuencia,
                        :movimientosfetales,
                        :consultaObs,
                        :estudiotipo,
                        :estudiodetalle,
                        :dolor,
                        :rehabilitaciones,
                        :mejora,
                        :suministrodetalle,
                        :notamedica,
                        :rx,
                        :resultados,
                        :infodetalle,
                        :hospitalarioDetalle,
                        :pase,
                        :identificacion,
                        :docdetalle
                  )";
            
            $temporal2 = $db->prepare($sql2);
            $temporal2->bindParam("clave", $clave);
            $temporal2->bindParam("diagnostico", $diagnostico);
            $temporal2->bindParam("justificacion", $justificacion);
            $temporal2->bindParam("consultatipo", $consultatipo);
            $temporal2->bindParam("embarazo", $embarazo);
            $temporal2->bindParam("controlgineco", $controlgineco);
            $temporal2->bindParam("semanas", $semanas);
            $temporal2->bindParam("dolorabdominal", $dolorabdominal);
            $temporal2->bindParam("frecuencia", $frecuencia);
            $temporal2->bindParam("movimientosfetales", $movimientosfetales);
            $temporal2->bindParam("consultaObs", $consultaObs);
            $temporal2->bindParam("estudiotipo", $estudiotipo);
            $temporal2->bindParam("estudiodetalle", $estudiodetalle);
            $temporal2->bindParam("dolor", $dolor);
            $temporal2->bindParam("rehabilitaciones", $rehabilitaciones);
            $temporal2->bindParam("mejora", $mejora);
            $temporal2->bindParam("suministrodetalle", $suministrodetalle);
            $temporal2->bindParam("notamedica", $notamedica);
            $temporal2->bindParam("rx", $rx);
            $temporal2->bindParam("resultados", $resultados);
            $temporal2->bindParam("infodetalle", $infodetalle);
            $temporal2->bindParam("hospitalarioDetalle", $hospitalarioDetalle);
            $temporal2->bindParam("pase", $pase);
            $temporal2->bindParam("identificacion", $identificacion);
            $temporal2->bindParam("docdetalle", $docdetalle);

            $temporal2->execute();


            mkdir("../solicitudes/".$clave);


            foreach ($archivos as $documento) {

                $archivo= $documento->archivo;
                $observaciones= $documento->observaciones;
                $tipoid = $documento->idtipo;
                $ubicacionactual = "../". $documento ->ubicacionreal; 
                $ubicacionnueva = "../solicitudes/".$clave."/".$archivo;

                // echo $archivo ."<br>";
                // echo $observaciones."<br>";
                // echo $tipoid."<br>";
                // echo $ubicacionactual."<br>";
                // echo $ubicacionnueva;

                
                rename( $ubicacionactual ,  $ubicacionnueva);

                $ubicacionnueva = str_replace( "../", "",$ubicacionnueva);

                $sql3 = "INSERT INTO ArchivosSolicitud
                      (
                             SOL_claveint,
                             TID_claveint,
                             ARS_ruta,
                             ARS_observaciones,
                             ARS_nombre                   
                      ) 
                      VALUES
                      (
                            :clave,
                            :tipo,
                            :ruta,
                            :observaciones,
                            :nombre
                      )";
                
                $temporal3 = $db->prepare($sql3);
                $temporal3->bindParam("clave", $clave);
                $temporal3->bindParam("tipo", $tipoid);
                $temporal3->bindParam("ruta", $ubicacionnueva);
                $temporal3->bindParam("observaciones", $observaciones);
                $temporal3->bindParam("nombre", $archivo);

                $temporal3->execute();

            }

            $respuesta = array('respuesta' => "Tu solicitud ha sido registrada correctamente", "clave" => $clave);
            //$correo($html);
        }else{
            $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información", "clave" => $clave);
        }
        
        echo json_encode($respuesta);

    }

}

if($funcion == 'guardaSolicitudInfo'){

    $db = conectarMySQL();
    $postdata = file_get_contents("php://input");
    //aplicacmos json_decode para manejar los datos como arreglos de php
    $datos = json_decode($postdata);

    //datos de folio
    $clave = $datos->clave;
    $usuario = $datos->usuario;
    $descripcion = $datos->descripcion;
    $archivos = $datos->soporte;

    $rutas = array();

    if(!$db) {

        die('Something went wrong while connecting to MSSQL');

    }else{

        //verificamos que exista la carpeta
        if (!file_exists($nombre_fichero)) {
            mkdir("../solicitudes/".$clave);
        } 

        //recorremos el arreglo de archivos que mandamos 
        foreach ($archivos as $documento) {

            $archivo= $documento->archivo;
            $observaciones= $documento->observaciones;
            $tipoid = $documento->idtipo;
            $ubicacionactual = "../". $documento ->ubicacionreal; 
            $ubicacionnueva = "../solicitudes/".$clave."/".$archivo;
            
            rename( $ubicacionactual ,  $ubicacionnueva);

            $ubicacionnueva = str_replace( "../", "",$ubicacionnueva);

            $sql3 = "INSERT INTO ArchivosSolicitud
                  (
                         SOL_claveint,
                         TID_claveint,
                         ARS_ruta,
                         ARS_observaciones,
                         ARS_nombre                   
                  ) 
                  VALUES
                  (
                        :clave,
                        :tipo,
                        :ruta,
                        :observaciones,
                        :nombre
                  )";
            
            $temporal3 = $db->prepare($sql3);
            $temporal3->bindParam("clave", $clave);
            $temporal3->bindParam("tipo", $tipoid);
            $temporal3->bindParam("ruta", $ubicacionnueva);
            $temporal3->bindParam("observaciones", $observaciones);
            $temporal3->bindParam("nombre", $archivo);

            $temporal3->execute();

            //incluimos en el arreglo las rutas de los archivos que utlizamos
            array_push($rutas, $ubicacionnueva);



        }
        
        //generemamos un string donde ponemos todas las rutas del arreglo separado por comas
        $listarutas = implode(",", $rutas);


        //insertamos el seguimiento 
        $sql = "INSERT INTO SeguimientoSolicitud
              (
                     SOL_claveint,
                     Usu_login,
                     SES_descripcion,
                     SES_fecha,
                     SES_leido,
                     SES_archivos                  
              ) 
              VALUES
              (
                    :clave,
                    :usuario,
                    :descripcion,
                    now(),
                    0,
                    :archivos
              )";
        
        $temporal = $db->prepare($sql);
        $temporal->bindParam("clave", $clave, PDO::PARAM_STR);
        $temporal->bindParam("usuario", $usuario, PDO::PARAM_STR);
        $temporal->bindParam("descripcion", $descripcion, PDO::PARAM_STR, 10);
        $temporal->bindParam("archivos", $listarutas, PDO::PARAM_STR);
        

        //ejecutamos la consulta
        if ($temporal->execute()){ 

            $respuesta = array('respuesta' => "Tu solicitud ha sido registrada");

        }else{
            $respuesta = array('respuesta' => "Los Datos No se Guardaron Verifique su Información");
        }

        
        echo json_encode($respuesta);

    }

}

if($funcion == 'solicitudes'){
    
    $usuario = '';

    $conexion = conectarMySQL();

    $sql = "SELECT Solicitudes.SOL_claveint AS clave, TIM_nombreE as tipo, Exp_folio as folio, SOL_lesionado as lesionado, SOL_fechaReg as fecharegistro, 
            SOL_fechaActualiza as fechaactualiza, Cia_nombrecorto as cliente, DATEDIFF(now() , SOL_fechaReg ) as diferencia FROM Solicitudes 
            INNER JOIN DetalleSolicitud ON DetalleSolicitud.SOL_claveint = Solicitudes.SOL_claveint
            LEFT JOIN Compania on Compania.Cia_clave = Solicitudes.Cia_clave
            LEFT JOIN TipoMovimiento ON TipoMovimiento.TIM_claveint = Solicitudes.TIM_claveint 
            WHERE SOL_estatus = 1 ";

    if (isset($_REQUEST['userapi'])) {
      $usuario = $_REQUEST['userapi'];
      $sql = $sql . " AND USU_login = '$usuario'";
      $sql = $sql . " ORDER BY Solicitudes.SOL_fechaReg ";
    }else{

      $sql = $sql . " ORDER BY Solicitudes.SOL_fechaReg ";
      $sql = $sql . " LIMIT 0,30";
    }


     


    $result = $conexion->query($sql);

    $datos = $result->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($datos);

    $conexion = null;

}


if($funcion == 'solicitudesInfo'){
    
  
    $conexion = conectarMySQL();

    $sql = "SELECT Solicitudes.SOL_claveint AS clave, TIM_nombreE as tipo, Exp_folio as folio, SOL_lesionado as lesionado, SOL_fechaReg as fecharegistro, SOL_fechaActualiza as fechaactualiza, Cia_nombrecorto as cliente FROM Solicitudes 
            INNER JOIN DetalleSolicitud ON DetalleSolicitud.SOL_claveint = Solicitudes.SOL_claveint
            LEFT JOIN Compania on Compania.Cia_clave = Solicitudes.Cia_clave
            LEFT JOIN TipoMovimiento ON TipoMovimiento.TIM_claveint = Solicitudes.TIM_claveint 
            WHERE SOL_estatus = 2 ";

    if (isset($_REQUEST['userapi'])) {
      $usuario = $_REQUEST['userapi'];
      $sql = $sql . "AND USU_login = '$usuario'";
    }else{
      $sql = $sql . "LIMIT 0,30";
    }


    $result = $conexion->query($sql);

    $datos = $result->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($datos);

    $conexion = null;

}

if($funcion == 'detalleSolicitudesInfo'){
    
    $clave = $_REQUEST['clave'];
    $datos = array();
    $dato = array();
    $archivos = array();
    $archivosTotales = array();

    $conexion = conectarMySQL();

    $sql = "SELECT SOL_claveint as clave , SES_descripcion as descripcion, SES_fecha as fecha, SES_leido as leido, Usuario.Usu_login as usuario, Usu_nombre as nombre, SES_archivos as archivos  
            FROM SeguimientoSolicitud
            INNER JOIN Usuario ON Usuario.Usu_login = SeguimientoSolicitud.Usu_login 
            WHERE SOL_claveint = '$clave' ORDER BY SES_fecha DESC";

    $result = $conexion->query($sql);

    foreach ($result as $info) {
      
      $clave = $info['clave'];
      $dato['clave'] = $info['clave'];
      $dato['descripcion'] = $info['descripcion'];
      $dato['fecha'] = $info['fecha'];
      $dato['leido'] = $info['leido'];
      $dato['usuario'] = $info['usuario'];
      $dato['nombre'] = $info['nombre'];

      if ($info['archivos'] != '') {

        $temporal = explode(",", $info['archivos']);
        
        foreach ($temporal as $archivo) {

          $archivos['ruta']  = $archivo;
          $nombre = str_replace( "solicitudes/".$clave."/" , "",$archivo);
          $archivos['nombre'] = $nombre;
          array_push($archivosTotales, $archivos);

        }

      }else{
        $archivosTotales = array();
      }

      $dato['archivos'] = $archivosTotales;

      array_push($datos, $dato);

    }
    
    echo json_encode($datos);

    $conexion = null;

}

if($funcion == 'solicitudesRespuestas'){
    
    $conexion = conectarMySQL();

    $sql = "SELECT Solicitudes.SOL_claveint AS clave, TIM_nombreE as tipo, Exp_folio as folio, SOL_lesionado as lesionado, SOL_fechaReg as fecharegistro, SOL_fechaActualiza as fechaactualiza, 
            Cia_nombrecorto as cliente, SOL_estatus as respuesta, DATEDIFF(SOL_fechaActualiza, SOL_fechaReg ) as diferencia FROM Solicitudes 
            INNER JOIN DetalleSolicitud ON DetalleSolicitud.SOL_claveint = Solicitudes.SOL_claveint
            LEFT JOIN Compania on Compania.Cia_clave = Solicitudes.Cia_clave
            LEFT JOIN TipoMovimiento ON TipoMovimiento.TIM_claveint = Solicitudes.TIM_claveint 
            WHERE SOL_estatus in (3,4) ";

    if (isset($_REQUEST['userapi'])) {
      $usuario = $_REQUEST['userapi'];
      $sql = $sql . "AND USU_login = '$usuario'";
    }else{
      $sql = $sql . "LIMIT 0,30";
    }

    $result = $conexion->query($sql);

    $datos = $result->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($datos);

    $conexion = null;

}

if ($funcion == 'temporal') {
    //Obtenemos la imagen que mandamos de angular
      if(isset($_FILES['file'])){
          //The error validation could be done on the javascript client side.       
          $file_name = $_FILES['file']['name'];
          $file_size =$_FILES['file']['size'];
          $file_tmp =$_FILES['file']['tmp_name'];
          $file_type=$_FILES['file']['type'];   
          $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

          move_uploaded_file($file_tmp,"../imgs/tmp/".$file_name);
          $resultado = array('ubicacion' => "imgs/tmp/".$file_name, 'temporal' => $file_tmp , 'tipo' => $file_type, 'nombre' => $file_name);

          echo json_encode($resultado);
          
      }

}

if($funcion == 'tipoDocumento'){

    $conexion = conectarMySQL();

    $sql = "SELECT * FROM TipoDocumento where TID_activa = 1";

    $result = $conexion->query($sql);

    $datos = $result->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($datos);

    $conexion = null;

}

// if($funcion == 'unidades'){

//     $conexion = conectarMySQL();

//     $sql = "SELECT * FROM Compania order BY Cia_nombrecorto";

//     $result = $conexion->query($sql);

//     $resultado = array();
//     $total = array();

//     //$datos = $result->fetchAll(PDO::FETCH_OBJ);
//     foreach ($result as $value) {

//         $clave = $value['Cia_clave'];
//         $nombre = $value['Cia_nombrecorto'];
//         $activa = $value['Cia_activa'];

//         if ($activa == 'S') {

//             $resultado['clave'] = $clave;
//             $resultado['nombre'] = $nombre;

//             array_push($total, $resultado);

//         }elseif ($activa == 'N' && $clave == '52') {

//             $resultado['clave'] = $clave; 
//             $resultado['nombre'] = $nombre;

//             array_push($total, $resultado);

//         }

        

//     } 

//     echo json_encode($total);

//     $conexion = null;

// }


if($funcion == 'usuarios'){

    $conexion = conectarMySQL();

    $sql = "SELECT * FROM Usuario";

    $result = $conexion->query($sql);

    $datos = $result->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($datos);

    $conexion = null;

}



?>
