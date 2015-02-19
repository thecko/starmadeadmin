var starMadeAdminControllers = angular.module('starMadeAdminControllers', []);

starMadeAdminControllers.controller('ShipListCtrl', ['$scope', 'Api',
    function ($scope, Api) {
        $scope.ships = Api.query({resourceName: 'ships', limit: 10});
        $scope.orderProp = 'name';

        $scope.totalItems = $scope.ships.total;
        $scope.currentPage = 1;

        $scope.setPage = function (pageNo) {
            $scope.currentPage = pageNo;
        };

        $scope.pageChanged = function () {
        };

        $scope.maxSize = 5;
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