var starMadeAdminApp = angular.module('starMadeAdminApp', [
  'ngRoute'
  , 'starMadeAdminAnimations'
  , 'starMadeAdminControllers'
  , 'starMadeAdminServices'
  , 'ui.bootstrap'
]);

starMadeAdminApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/ships', {
        templateUrl: 'partials/ship-list.html',
        controller: 'ShipListCtrl'
      }).
      when('/ships/:shipId', {
        templateUrl: 'partials/ship-detail.html',
        controller: 'ShipDetailCtrl'
      }).
      when('/characters', {
        templateUrl: 'partials/character-list.html',
        controller: 'CharacterListCtrl'
      }).
      when('/characters/:characterId', {
        templateUrl: 'partials/character-detail.html',
        controller: 'CharacterDetailCtrl'
      }).
    when('/blueprints', {
        templateUrl: 'partials/blueprint-list.html',
        controller: 'BlueprintListCtrl'
      }).
    when('/blueprints/:uniqueid', {
        templateUrl: 'partials/blueprint-detail.html',
        controller: 'BlueprintDetailCtrl'
    }).
    otherwise({
        redirectTo: '/ships'
    });
  }]);