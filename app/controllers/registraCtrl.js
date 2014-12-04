app.controller('registraCtrl', function($scope,$rootScope, $http,$cookies,$location) {	

$scope.inicio = function(){
    $scope.mensajeError=false;
    $rootScope.rutaImgPro=$cookies.rutaImgPro;
    $rootScope.rutaImgCom= $cookies.rutaImgCom;
    $rootScope.ciaClave= $cookies.clave;
    $rootScope.cveProd= $cookies.clavePro;

    $scope.validaInputAut=false;
    $scope.veCDB=false;
    $scope.respuesta ='';
    $scope.segundaEtapa=false;
    $scope.errorAut=false;
    $scope.veCupon=false;

    $scope.datos={
    	nombre:'',
    	pat:'',
    	mat:'',
    	fecnac:'',
    	tel:'',
    	numeroTel:'',
    	correo:''
    }
    $scope.datosSin={
        cobAfec:'',
        inciso:'',
        noCia:'',
        poliza:'',
        siniestro:'',
        reporte:'',
        folPase:'',
        obs:''
    }

    $scope.prueba = 'algo';
}

/*
$scope.validaEmail = function(){
        alert($scope.datos.mail);
        $scope.valida=valMail($scope.datos.mail);
        if($scope.valida){
            $scope.veCupon=true;
        }
}*/

$scope.$watch('datos.correo',function(valorant,valornuev){    
    if(valorant){
        $scope.veCupon=true;
    }
    else{
        $scope.veCupon=false;   
    }
});

$scope.guardaEtapa1 = function(){
		console.log($scope.datos);
		$rootScope.usrLogin =  $cookies.usrLogin;
		$rootScope.uniClave = $cookies.uniClave;

		$scope.mensaje = '';       
        $http({
            url:'api/api.php?funcion=registra&usr='+$rootScope.usrLogin+'&uniClave='+$rootScope.uniClave+'&ciaClave='+$rootScope.ciaClave+'&prod='+$rootScope.cveProd,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.datos
        }).success( function (data){            
            $scope.mensaje = data.respuesta;
            $scope.folio = data.folio;

            $scope.veCDB=true;
            console.log($scope.folio);
            if($rootScope.ciaClave==44){
                $scope.autoriza=true;             
                $scope.primeraEtapa=true;
                $scope.btnGuardar=true;
            }else{
                if($rootScope.ciaClave==19){
                    $scope.noCompania='Folio Electrónico';
                }
                else if($rootScope.ciaClave=10){
                    $scope.noCompania='Folio de Derivación';   
                }
                else {
                    $scope.noCompania='No. Compañía';
                }
                $scope.validaPase=true;
                $scope.primeraEtapa=true;
                $scope.btnGuardar=true;
                



                $http({
                    url:'api/api.php?funcion=catCobertura',
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':1}
                    }).success( function (data){ 
                        console.log(data);                              
                        $scope.list= data;
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');

                    });


                }                                    
                }).error( function (xhr,status,data){
                	$scope.mensaje ='no entra';            
                    alert('Error');
                });
    }
    
    $scope.validaAutorizacion= function(){
        $scope.validaInputAut=true;
        $scope.errorAut=false;
        if($scope.autorizacion!=''){
            noAut=$scope.autorizacion;            
            $http({
                    url:'api/api.php?funcion=validaAut',
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'aut':noAut}
                    }).success( function (data){   
                        if(data.respuesta=='correcto'){                            
                            $scope.segundaEtapa=true;
                            $scope.validaPase=false;
                            $scope.validaInputAut=false;
                            $scope.mensaje='';
                        } 
                        else{
                            $scope.errorAut=true;
                        }                                         
                        $scope.respuesta= data.aut;
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }

    }

    $scope.guardaEtapa2 = function(){
        console.log($scope.datosSin);
        if($rootScope.ciaClave==19&&$scope.datosSin.siniestro==''&&$scope.datosSin.reporte==''){
            $scope.mensajeError=true;
        }else{
            $scope.mensajeError=false;
        $http({
            url:'api/api.php?funcion=registraSin&fol='+$scope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.datosSin
            }).success( function (data){   
                console.log(data);
                if(data.respuesta=='correcto'){                            
                  $cookies.folio = data.folio;
                  $location.path("/portada");
                } 
                else{
                    $scope.errorAut=true;
                }                                        
                $scope.respuesta= data.aut;
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';                            
            });
        }
    }    
});

function valMail(valor) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/.test(valor)){
   return true;
  } else {
   return false;
  }
}