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
        $scope.cia_clave=data.Cia_clave;
        $scope.pro_clave=data.Pro_clave;  	
		$scope.cia=data.Cia_nombrecorto;	
		$scope.uniMed = data.Uni_nombre;
		$scope.poliza = data.Exp_poliza;
		$scope.sinicestro = data.Exp_siniestro;
		$scope.reporte =data.Exp_reporte;
		$scope.riesgo =data.RIE_nombre;
		$scope.lesionado = data.Exp_nombre+' '+data.Exp_paterno+' '+data.Exp_materno;
		$scope.usuario=data.Usu_registro;
		$scope.registro=data.Exp_fecreg;       
         if($rootScope.rutaAse==''||$rootScope.rutaAse==null){
        cveCia=$scope.cia_clave;
        imgCia=$scope.imgCompania(cveCia);        
        $rootScope.rutaAse=imgCia;       
        }
        if($rootScope.rutaPro==''||$rootScope.rutaPro==null){
            cvePro=$scope.pro_clave;
            imgPro=$scope.validarutaProducto(cvePro);
            $rootScope.rutaPro=imgPro;
        }
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

    $scope.imgCompania = function(claveCompania){
        var img=0;        
        switch(claveCompania){          
        case '1':
            img="aba.jpg";
            break;        
        case '33':
            img="ace.jpg";
            break;
         case '2':
            img="afirme.jpg";
            break;
         case '3':
            img="aguila.jpg";
            break;
         case '4':
            img="aig.jpg";
            break;
         case '5':
            img="ana.jpg";
            break;
         case '6':
            img="atlas.jpg";
            break;
         case '7':
            img="axa.jpg";
            break;
         case '8':
            img="banorte.jpg";
            break;
         case '43':
            img="ci.jpg";
            break;
         case '44':
            img="cortesia.jpg";
            break;
         case '39':
            img="futv.JPG";
            break;
         case '40':
            img="futv2.JPG";
            break;
         case '9':
            img="general.jpg";
            break;
         case '10':
            img="gnp.jpg";
            break;
         case '11':
            img="goa.jpg";
            break;
         case '12':
            img="hdi.jpg";
            break;
         case '31':
            img="hir.jpg";
            break;
         case '45':
            img="inbursa.jpg";
            break;
         case '14':
            img="latino.jpg";
            break;
         case '41':
            img="lidnorte.JPG";
            break;
         case '15':
            img="mapfre.jpg";
            break;
         case '16':
            img="metro.jpg";
            break;
         case '37':
            img="multiafirme.jpg";
            break;
         case '35':
            img="multibancomer.jpg";
            break;
         case '36':
            img="multizurich.jpg";
            break;
         case '17':
            img="multiva.jpg";
            break;
         case '51':
            img="Ortho.jpg";
            break;
         case '18':
            img="potosi.jpg";
            break;
         case '22':
            img="primero.jpg";
            break;
         case '19':
            img="qualitas.jpg";
            break;
         case '20':
            img="rsa.jpg";
            break;
         case '32':
            img="spt.JPG";
            break;
         case '47':
            img="thona.jpg";
            break;
         case '34':
            img="travol.jpg";
            break;
        }        
        return img;
    }
    $scope.validarutaProducto = function(claveProducto){
        imgPro=0;
        switch (claveProducto) {
        case '1':
            imgPro="av.jpg";
            break;
        
        case '2':
            imgPro="ap.jpg";
            break;
        case '3':
            imgPro="es.jpg";
            break;
        case '4':
            imgPro="rh.jpg";
            break;
        case '5':
            imgPro="rh.jpg";
            break;
        case '6':
            imgPro="sq.jpg";
            break;
        case '7':
            imgPro="sn.jpg";
            break;
        case '8':
            imgPro="sn.jpg";
            break;
        }
        return imgPro;
    }
});