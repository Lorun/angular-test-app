'use strict';

angular.module('customer.controllers', [])

.controller('MainCtrl', ['$scope', '$route', '$routeParams', '$location', function($scope, $route, $routeParams, $location) {
     $scope.$route = $route;
     $scope.$location = $location;
     $scope.$routeParams = $routeParams;
}])

.controller('listCtrl', ['$scope', 'Customer', '$routeParams', function($scope, Customer, $routeParams) {
    
    $scope.deleteItem = function(item) {
        Customer.delete({id: item.id}, function(){
            $scope.customers.splice($scope.customers.indexOf(item), 1);
        });
    };

    $scope.customers = Customer.all();
}])

.controller('editCtrl', ['$scope', 'Customer', '$routeParams', '$location', function($scope, Customer, $routeParams, $location) {
    $scope.customer = Customer.get({id: $routeParams.id});

    $scope.save = function() {
        $scope.customer.$save({id:$scope.customer.id}, function(){ $location.path('/list'); });
    };
}])

.controller('createCtrl', ['$scope', 'Customer', '$routeParams', '$location', function($scope, Customer, $routeParams, $location) {
    $scope.customer = new Customer();

    $scope.save = function() {
        Customer.create($scope.customer, function(){ $location.path('/list'); });
    }
}])