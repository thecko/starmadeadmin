var starMadeAdminControllers = angular.module('starMadeAdminControllers', []);

starMadeAdminControllers.controller('ShipListCtrl', ['$scope', 'Api', '$stateParams' ,
    function ($scope, Api , $stateParams ) {

        $scope.maxSize = 5;
        $scope.itemsPerPage = 5;
        $scope.currentPage = $stateParams.page;
        $scope.offset = 0;
        $scope.order = $stateParams.order ? $stateParams.order : 'name';
        $scope.query = '';

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
            });
        };
        $scope.queryChanged = function(){
            //$scope.currentPage = 1;
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