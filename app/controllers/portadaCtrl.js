app.controller('portadaCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.rutaAse=	$cookies.rutaImgCom; 
	$rootScope.folio= 	$cookies.folio;
	$rootScope.rutaPro=	$cookies.rutaImgPro;	
	$scope.cia='';
	$scope.uniMed='';
	$scope.poliza='';
	$scope.sinicestro='';
	$scope.reporte='';
	$scope.riesgo='';
	busquedas.buscarFolio($rootScope.folio).success(function(data){
		console.log(data);	
		$scope.cia=data.Cia_nombrecorto;	
		$scope.uniMed = data.Uni_nombre;
		$scope.poliza = data.Exp_poliza;
		$scope.sinicestro = data.Exp_siniestro;
		$scope.reporte =data.Exp_reporte;
		$scope.riesgo =data.RIE_nombre;
		$scope.lesionado = data.Exp_nombre+' '+data.Exp_paterno+' '+data.Exp_materno;
		$scope.usuario=data.Usu_registro;
		$scope.registro=data.Exp_fecreg;
	});

	$scope.imprimePortada = function(){  

	var fileName = "Reporte";
 	var uri = 'api/classes/formatoFolio.php?fol='+$rootScope.folio;
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".pdf";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);





        /*$http({
            url:'api/api.php?funcion=imprimePortada&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data:{clave:'valor'}
            }).success( function (data){   
                console.log(data);                
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';                            
            });*/
    }
});