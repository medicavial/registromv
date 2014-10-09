app.controller('registraCtrl', function($scope,$rootScope, $http,$cookies) {	

$scope.inicio = function(){
    
    $rootScope.rutaImgPro=$cookies.rutaImgPro;
    $rootScope.rutaImgCom= $cookies.rutaImgCom;
    $rootScope.ciaClave= $cookies.clave;
    $rootScope.cveProd= $cookies.clavePro;

    $scope.validaInputAut=false;

    $scope.datos={
    	nombre:'',
    	pat:'',
    	mat:'',
    	fecnac:'',
    	tel:'',
    	numeroTel:'',
    	mail:''
    }
}
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
    }
});