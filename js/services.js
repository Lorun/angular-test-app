'use strict';

angular.module('customer.services', ['ngResource'])

.service('Customer', ['$resource', function($resource){
	return $resource('back/:id', {id: "@id"}, {
		create: { method:'PUT' },
		all: {method:'GET', params:{id:'list'}, isArray:true}
	});
}])

.service('checkUnique', ['$http', function ($http) {
    return function (id, property, value) {
        if (!id) id = 0;
        return $http.post('back/' + id + '/checkUnique/', { property: property, value: value })
            .then(function (results) {
                console.log(results.data.status);
                return results.data.status;
        });
    };
}]);