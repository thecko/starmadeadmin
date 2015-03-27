var starMadeAdminApp = angular.module('starMadeAdminApp', [
  'ngRoute'
  , 'starMadeAdminAnimations'
  , 'starMadeAdminControllers'
  , 'starMadeAdminServices'
  , 'ui.bootstrap'
  , 'ui.router'
  , 'LocalStorageModule'
]);

starMadeAdminApp.config(function($stateProvider, $urlRouterProvider, localStorageServiceProvider) {
    
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
      url: "ships"
      , params : {
        page : 1
        , order : 'name'
        , query : null
      }
      , templateUrl: "partials/ship-list.html"
      , controller: 'ShipListCtrl'
    })
    .state('loggedin.shipdetail', {
      url: "ships/:uniqueid?page&order&query"
      , templateUrl: "partials/ship-detail.html"
      , controller: 'ShipDetailCtrl'
    });

    localStorageServiceProvider.setPrefix("starMadeAdminApp")
  });