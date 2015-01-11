<?php ?>

<!doctype html>
<html lang="es" ng-app="starMadeAdminApp">
  <head>
    <meta charset="utf-8">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-resource.min.js"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-animate.min.js"></script>    
    <script src="js/app.js"></script>
    <script src="js/services.js"></script>
    <script src="js/controllers.js"></script>
    <script src="js/animations.js"></script>

    <title>Star-Made.es Server Admin panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
  </head>
  <body>    
    <div class="jumbotron">
      <div class="container">
        <h1>Admin starmade</h1>
      </div>
    </div>
    <div class="container">
      <div ng-view></div>      
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>