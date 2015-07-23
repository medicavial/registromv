<?php
include ('myClasses/Addendum.php');
include ('myClasses/Suministros.php');
include ('myClasses/Incidencias.php');

set_time_limit(3600);
//sin limite me memoria 
ini_set('memory_limit', '-1');
//ocultar los errores
error_reporting(0);

date_default_timezone_set('America/Mexico_City'); //Ajustando zona horaria

$funcion=$_GET['funcion'];



if($funcion=='agregarAddendum'){

    $usuarioModel = new Addendum();
    $fol    =$_GET['fol'];
    $cuerpo = $_GET['cuerpo'];
    $usr    = $_GET['usr'];
    $tipDoc = $_GET['tipDoc'];
    $postdata = file_get_contents("php://input");    
    $data = json_decode($postdata);    
    $a_users = $usuarioModel->setAddendum($fol,$data,$usr);    
    echo $a_users;
}

if($funcion=='buscaSubs'){

    $usuarioModel = new Addendum();
    $fol    =$_GET['fol'];
    $numSub = $usuarioModel->getSubsecuencias($fol);    
    echo $numSub;
}

if($funcion=='enviaComentarioRH'){

    $usuarioModel = new Addendum();
    $fol    =$_GET['fol'];
    $cuerpo = $_GET['cuerpo'];
    $usr    = $_GET['usr'];
    $tipDoc	= $_GET['tipDoc'];
    $a_users = $usuarioModel->setAddendum($fol,$cuerpo,$usr,$tipDoc);    
    echo json_encode($a_users);
}

if($funcion=='recargaMedSymio'){

   $cargaSuministros= new Suministros();

    $uni    =$_GET['uni'];
    $suministro = $cargaSuministros->setSuministros($uni);         
    if($suministro=='exito'){
        $respuesta = $cargaSuministros->getSuministros($uni);
        echo json_encode($respuesta);        
    }else{
        echo json_encode('error');   
    }
}

if($funcion=='guardaMedicamentosAlternativos'){ 
    $folio    =$_GET['fol'];      
    $guardaMedicAlter = new Suministros();
    
    $postdata = file_get_contents("php://input");    
    $data = json_decode($postdata);    
    $suministro = $guardaMedicAlter->setSumAlter($folio, $data);     
    if($suministro=='exito'){
       $listadoSumAlter = $guardaMedicAlter->getSuministrosAlternativos($folio);
       echo json_encode($listadoSumAlter); 
    }else{
        echo 'error';
    }
}

if($funcion=='guardaOrtesisAlternativos'){ 
    $folio    =$_GET['fol'];      
    $guardaOrteAlter = new Suministros();    
    $postdata = file_get_contents("php://input");    
    $data = json_decode($postdata);    
    $suministro = $guardaOrteAlter->setOrtAlter($folio, $data);     
    if($suministro=='exito'){
       $listadoOrtAlter = $guardaOrteAlter->getOrtesisAlternativos($folio);
       echo json_encode($listadoOrtAlter); 
    }else{
        echo 'error';
    }
}

/****************** funcion para guardar incidencias **********************************/

if($funcion=='guardaIncidencia'){ 
    $usr    =$_GET['usr'];      
    $uni    =$_GET['uni'];       
    $guardaIncidencia = new Incidencias();    
    $postdata = file_get_contents("php://input");    
    $data = json_decode($postdata);        
    $incidencia = $guardaIncidencia->setIncidencia($usr,$uni,$data);
    if($incidencia=='exito'){
        $correoEnviado=$guardaIncidencia->sendIncidencia($usr,$uni,$data);
        echo $correoEnviado;
    }         
}
/*********************fin de guardado de insidencias ***********************************/


    

?>
