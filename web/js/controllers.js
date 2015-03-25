var starMadeAdminControllers = angular.module('starMadeAdminControllers', []);

starMadeAdminControllers.controller('ShipListCtrl', ['$scope', 'Api', '$state' ,'$stateParams',
    function ($scope, Api, $state, $stateParams) {

        $scope.maxSize = 5;
        $scope.itemsPerPage = 5;
        $scope.currentPage = $stateParams.page;
        $scope.offset = ($scope.currentPage - 1) * $scope.itemsPerPage;
        $scope.order = $stateParams.order ? $stateParams.order : 'name';
        $scope.query = $stateParams.query ? $stateParams.query : '';
        
        Api.query({
            resourceName: 'ships'
            , limit: $scope.itemsPerPage
            , offset: $scope.offset
            , term: $scope.query
            , order: $scope.order
        })
        .$promise.then(function (data) {
            $scope.ships = data;
            $scope.totalItems = $scope.ships.count;
            $scope.currentPage = Math.floor(data.offset / data.limit) + 1;
        });
        
        $scope.pageChanged = function () {
            $state.go("loggedin.ships",{
                page:$scope.currentPage
                , order:$scope.order
                , query:$scope.query
            });
        };
        $scope.queryChanged = function () {
            $scope.currentPage = 1;
            $scope.pageChanged();
        }
        
        $scope.shipDetail = function( entityId ){
            $state.go("loggedin.ships.detail",{
                page:$scope.currentPage
                , order:$scope.order
                , query:$scope.query
                , shipid: entityId
            });
        }
    }]);

starMadeAdminControllers.controller('ShipDetailCtrl',['$scope', 'Api', '$state' ,'$stateParams',
    function ($scope, Api, $state, $stateParams) {
        $scope.ship = Api.get({resourceName: 'ships', entityId: $stateParams.uniqueid});
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