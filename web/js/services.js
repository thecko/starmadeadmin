var starMadeAdminServices = angular.module('starMadeAdminServices', ['ngResource']);

starMadeAdminServices.factory('Api', ['$resource',
  function($resource){
    return $resource(
        '/app_dev.php/:resourceName/:entityId\.json?apikey=asdasdasd&limit=:limit&offset=:offset&term=:term'
        , {}
        , {
            query: {
              method:'GET'
              , params:{ 
                resourceName :''
                ,entityId:''
                ,limit:5
                ,offset:0
                ,term:''
              }
              , isArray:false 
            }
          }
        );
  }]);