var starMadeAdminServices = angular.module('starMadeAdminServices', ['ngResource']);

starMadeAdminServices.factory('Api', ['$resource',
  function($resource){
    return $resource(
        '/app_dev.php/:resourceName/:entityId\.json?apikey=asdasdasd&limit=:limit'
        , {}
        , {
            query: {
              method:'GET'
              , params:{ 
                resourceName :''
                ,entityId:''
                ,limit:100
              }
              , isArray:false 
            }
          }
        );
  }]);