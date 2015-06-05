'use strict';

angular.module('customer', ['ngRoute', 'customer.services', 'customer.controllers', 'customer.directives'])

.config(['$routeProvider', function($routeProvider) {
        $routeProvider
            .when('/list', {templateUrl: 'partials/list.html', controller: 'listCtrl'})
            .when('/create', {templateUrl: 'partials/edit.html', controller: 'createCtrl'})
            .when('/edit/:id', {templateUrl: 'partials/edit.html', controller: 'editCtrl'})
            .otherwise({redirectTo: '/list'});
}]);