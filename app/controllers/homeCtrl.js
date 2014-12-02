app.controller('homeCtrl', function($scope, $rootScope,$cookies) {   
    $rootScope.permisos=JSON.parse($cookies.permisos);
    
});


///estructura de controlador
// app.controller('nombredelcontroladorCtrl',function (dependencias $scope,nombrefactoria,$rootScope) {
// 	// codigos con funciones varaibles
// 	// $scope.variable
// })