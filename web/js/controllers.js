var starMadeAdminControllers = angular.module('starMadeAdminControllers', []);

starMadeAdminControllers.controller('ShipListCtrl', ['$scope', 'Api', '$state', '$stateParams', '$timeout', 'localStorageService',
    function ($scope, Api, $state, $stateParams, $timeout, localStorageService ) {

        $scope.currentPage = $stateParams.page ? $stateParams.page : localStorageService.get("ships.page") ;
        $scope.order = $stateParams.order ? $stateParams.order : localStorageService.get("ships.order");
        $scope.query = $stateParams.query ? $stateParams.query : localStorageService.get('ships.query');
        $scope.maxSize = 5;
        $scope.itemsPerPage = 5;
        $scope.offset = ($scope.currentPage - 1) * $scope.itemsPerPage;

        // Store
        localStorageService.set( 'ships.page' , $scope.currentPage);
        localStorageService.set( 'ships.order' , $scope.order);
        localStorageService.set( 'ships.query' , $scope.query);
        
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
            $state.go("loggedin.ships", {
                page: $scope.currentPage
                , order: $scope.order
                , query: $scope.query
            });
        };

        var timer = false;
        var firstExecution = true;
        $scope.$watch('query', function () {
            if (timer) {
                $timeout.cancel(timer);
            }
            if (!firstExecution) {
                timer = $timeout(function () {
                    $scope.currentPage = 1;
                    $scope.pageChanged();
                }, 1000);
            }
            firstExecution = false;
        });

    }]);

starMadeAdminControllers.controller('ShipDetailCtrl', ['$scope', 'Api', '$state', '$stateParams',
    function ($scope, Api, $state, $stateParams) {
        $scope.page = $stateParams.page;
        $scope.order = $stateParams.order;
        $scope.query = $stateParams.query;
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