<?php ?>

<!doctype html>
<html lang="es" ng-app="starMadeAdminApp">
    <head>
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/angular-route.min.js"></script>    
        <script src="js/angular-resource.min.js"></script>    
        <script src="js/angular-animate.min.js"></script>    
        <script src="js/angular-ui-router.js"></script>
        <script src="js/app.js"></script>
        <script src="js/services.js"></script>
        <script src="js/controllers.js"></script>
        <script src="js/animations.js"></script>

        <title>Star-Made.es Server Admin panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->    
        <link rel="stylesheet" href="css/bootstrap.min.css">    
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    </head>
    <body>    
        <div class="jumbotron">
            <div class="container">
                <h1>Admin starmade</h1>
            </div>
        </div>
        <div class="container">
            <div ui-view></div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/ui-bootstrap-tpls-0.12.0.js"></script>
    </body>
</html>