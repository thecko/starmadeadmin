var starMadeAdminControllers = angular.module('starMadeAdminControllers', []);

starMadeAdminControllers.controller('ShipListCtrl', ['$scope', 'Api', '$rootScope',
    function ($scope, Api, $rootScope ) {
        if( !$rootScope.ships ){
            $rootScope.ships = {
                maxSize : 5
                , itemsPerPage : 5
                , currentPage : 1
                , offset : 0
                , order : 'name'
                , itemsPerPageOptions : [10, 50, 100, 500]
                , query : ''
            };
        }
        
        $scope.maxSize = $rootScope.ships.maxSize;
        $scope.itemsPerPage = $rootScope.ships.itemsPerPage;
        $scope.currentPage = $rootScope.ships.currentPage;
        $scope.offset = $rootScope.ships.offset;
        $scope.order = $rootScope.ships.order;
        $scope.query = $rootScope.ships.query;

        $scope.pageChanged = function () {
            $scope.offset = ($scope.currentPage-1) * $scope.itemsPerPage;
            Api.query({
                resourceName: 'ships'
                , limit: $scope.itemsPerPage
                , offset: $scope.offset
                , term: $scope.query
                , order: $scope.order
            })
            .$promise.then( function(data){
                $scope.ships = data;
                $scope.totalItems = $scope.ships.count;
                
                // Store
                $rootScope.ships.offset = $scope.offset;
                $rootScope.ships.itemsPerPage = $scope.itemsPerPage;
                $rootScope.ships.currentPage = $scope.currentPage;
                $rootScope.ships.query = $scope.query;
                $rootScope.ships.order = $scope.order;
            });
        };
        $scope.queryChanged = function(){
            $scope.pageChanged();
        }
        $scope.pageChanged();
    }]);

starMadeAdminControllers.controller('ShipDetailCtrl', ['$scope', '$routeParams', 'Api',
    function ($scope, $routeParams, Api) {
        $scope.ship = Api.get({resourceName: 'ships', entityId: $routeParams.shipId});
    }]);

starMadeAdminControllers.controller('CharacterListCtrl', ['$scope', 'Api',
    function ($scope, Api) {
        $scope.characters = Api.query({resourceName: 'characters'});
        $scope.orderProp = 'name';
    }]);

starMadeAdminControllers.controller('CharacterDetailCtrl', ['$scope', '$routeParams', 'Api',
    function ($scope, $routeParams, Api) {
        $scope.character = Api.get({resourceName: 'characters', entityId: $routeParams.characterId});
    }]);

starMadeAdminControllers.controller('BlueprintListCtrl', ['$scope', 'Api',
    function ($scope, Api) {
        $scope.blueprints = Api.query({resourceName: 'blueprints'});
        $scope.orderProp = 'name';
    }]);

starMadeAdminControllers.controller('BlueprintDetailCtrl', ['$scope', '$routeParams', 'Api',
    function ($scope, $routeParams, Api) {
        $scope.blueprint = Api.get({resourceName: 'blueprints', entityId: $routeParams.uniqueid});
    }]);