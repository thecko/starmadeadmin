var starMadeAdminControllers = angular.module('starMadeAdminControllers', []);

starMadeAdminControllers.controller('ShipListCtrl', ['$scope', 'Api',
    function ($scope, Api) {
        $scope.maxSize = 5;
        $scope.itemsPerPage = 5;
        $scope.currentPage = 1;
        $scope.offset = 0;
        $scope.orderProp = 'name';
        $scope.itemsPerPageOptions = [10, 50, 100, 500];

        $scope.queryChanged = function () {
            $scope.offset = ($scope.currentPage-1) * $scope.itemsPerPage;
            $scope.ships = Api.query({
                resourceName: 'ships'
                , limit: $scope.itemsPerPage
                , offset: $scope.offset
                , term: $scope.query
            })
            .$promise.then( function(data){
                $scope.ships = data;
                $scope.totalItems = $scope.ships.count;
            });
        };
        Api.query({
            resourceName: 'ships'
            , limit: $scope.itemsPerPage
            , offset: $scope.offset
            , term: $scope.query
        })
        .$promise.then( function(data){
            $scope.ships = data;
            $scope.totalItems = $scope.ships.count;
        });

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