var starMadeAdminApp = angular.module('starMadeAdminApp', [
  'ngRoute'
  , 'starMadeAdminAnimations'
  , 'starMadeAdminControllers'
  , 'starMadeAdminServices'
  , 'ui.bootstrap'
  , 'ui.router'
]);

starMadeAdminApp.config(function($stateProvider, $urlRouterProvider) {
    
  // For any unmatched url, redirect to /state1
  $urlRouterProvider.otherwise("/loggedin");
  //
  // Now set up the states
  $stateProvider
    .state('loggedin', {
      url: "/",
      templateUrl: "partials/loggedin.html"
    })
    .state('loggedin.ships', {
      url: "ships?page&order"
      , templateUrl: "partials/ship-list.html"
      , controller: 'ShipListCtrl'
    });

    /*
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
    */
  });