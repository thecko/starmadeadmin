var starMadeAdminServices = angular.module('starMadeAdminServices', ['ngResource']);

starMadeAdminServices.factory('Api', ['$resource',
  function($resource){
    return $resource(
        '/app_dev.php/:resourceName/:entityId\.json'
        , {}
        , {
            query: {
              method:'GET'
              , params:{ 
                resourceName :''
                ,entityId:''
              }
              , isArray:false 
            }
          }
        );
  }]);