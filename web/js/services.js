var starMadeAdminServices = angular.module('starMadeAdminServices', ['ngResource']);

starMadeAdminServices.factory('Api', ['$resource',
  function($resource){
    return $resource(
        '/app.php/:resourceName/:entityId\.json'
        , {}
        , {
            query: { method:'GET', params:{ resourceName :'',entityId:''}, isArray:false }
        });
  }]);