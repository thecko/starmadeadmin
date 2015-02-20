var starMadeAdminServices = angular.module('starMadeAdminServices', ['ngResource']);

starMadeAdminServices.factory('Api', ['$resource',
  function($resource){
    return $resource(
        '/app_dev.php/:resourceName/:entityId\.json?apikey=asdasdasd&limit=:limit&offset=:offset'
        , {}
        , {
            query: {
              method:'GET'
              , params:{ 
                resourceName :''
                ,entityId:''
                ,limit:100
                ,offset:0
              }
              , isArray:false 
            }
          }
        );
  }]);