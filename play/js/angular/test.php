<?php 
require 'public.php'; 
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
<script src="https://apps.bdimg.com/libs/angular-route/1.3.13/angular-route.js"></script>

<script type="text/javascript">
angular.module('ngRouteExample', ['ngRoute'])
.controller('HomeController', function ($scope, $route) { $scope.$route = $route;})
.controller('AboutController', function ($scope, $route) { $scope.$route = $route;})
.config(function ($routeProvider) {
    $routeProvider.
    when('/home', {
        templateUrl: 'embedded.home.html',
        controller: 'HomeController'
    }).
    when('/about', {
        templateUrl: 'embedded.about.html',
        controller: 'AboutController'
    }).
    otherwise({
        redirectTo: '/home'
    });
});
</script>

  
</head>

<body ng-app="ngRouteExample" class="ng-scope">
  <script type="text/ng-template" id="embedded.home.html">
      <h1> Home </h1>
  </script>

  <script type="text/ng-template" id="embedded.about.html">
      <h1> About </h1>
  </script>

  <div> 
    <div id="navigation">  
      <a href="#/home">Home</a>
      <a href="#/about">About</a>
    </div>
      
    <div ng-view="">
    </div>
  </div>
</body>
</html>

<!-- <div ng-app="myApp" ng-controller="myCtrl"> -->
<!-- 	<h1>姓氏为 {{lastname}} 家族成员:</h1> -->
<!-- 	<ul> -->
<!-- 		<li ng-repeat="x in names">{{x}} {{lastname}}</li> -->
<!-- 	</ul> -->
<!-- </div> -->
<!-- <script> -->
<!-- // var app = angular.module('myApp', []); -->
<!-- // app.controller('myCtrl', function($scope, $rootScope) { -->
<!-- // 	$rootScope.names = ["Emil", "Tobias", "Linus"]; -->
<!-- // 	$rootScope.lastname = "Refsnes"; -->
<!-- // }); -->
<!-- </script> -->

<!-- <div ng-app="" ng-init="names=[ -->
<!-- {name:'Jani',country:'Norway'}, -->
<!-- {name:'Hege',country:'Sweden'}, -->
<!-- {name:'Kai',country:'Denmark'}]"> -->
<!-- 	<p>循环对象：</p> -->
<!-- 	<ul> -->
<!-- 		<li ng-repeat="x    in names"> -->
<!-- 			{{ x.name + ', ' + x.country }} -->
<!-- 		</li> -->
<!-- 	</ul> -->
<!-- </div> -->

<!-- <div ng-app=""> -->
<!-- 	<p>我的第一个表达式： {{ 5 + "" + 5 }}</p> -->
<!-- </div> -->

<!-- <div ng-app="" ng-init="firstName='John'"> -->
<!-- 	<p>姓名为 <span ng-bind="firstName"></span></p> -->
<!-- </div> -->

<!-- <div ng-app=""> -->
<!-- 	<p>名字 : <input type="text" ng-model="name"></p> -->
<!-- 	<h1>Hello {{name}}</h1> -->
<!-- </div> -->


