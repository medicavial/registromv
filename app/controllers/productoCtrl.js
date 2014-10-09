app.controller('productoCtrl', function($scope,$rootScope,$location,$cookies) {
	$scope.registraLesionado = function(claveProducto){
		rutaImgProd = $scope.validarutaProducto(claveProducto);
    	$cookies.rutaImgPro = rutaImgProd;    
    	$cookies.clavePro = claveProducto;      
        	$location.path("/registra");
    }    
    $scope.validarutaProducto = function(claveProducto){
		switch (claveProducto) {
	    case 1:
	        imgPro="av.jpg";
	        break;
	    
	    case 2:
	        imgPro="ap.jpg";
	        break;
	    case 3:
	        imgPro="es.jpg";
	        break;
	    case 4:
	        imgPro="rh.jpg";
	        break;
	    case 5:
	        imgPro="rh.jpg";
	        break;
	    case 6:
	        imgPro="sq.jpg";
	        break;
	    case 7:
	        imgPro="sn.jpg";
	        break;
		}
		return imgPro;
    }

});