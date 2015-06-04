'use strict';

angular.module('customer.services', ['ngResource'])

.factory('Customer', ['$resource', function($resource){
	return $resource('back/:id', {id: "@id"}, {
		create: { method:'PUT' },
		all: {method:'GET', params:{id:'list'}, isArray:true}
	});
}])