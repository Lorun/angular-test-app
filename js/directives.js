angular.module('customer.directives', [])
    

.directive('ngUnique', ['checkUnique', function (checkUnique) {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            element.bind('blur', function (e) {
                if (!ngModel || !element.val()) return;
                var keyProperty = scope.$eval(attrs.ngUnique);
                var currentValue = element.val();

                checkUnique(keyProperty.key, keyProperty.property, currentValue)
                    .then(function (unique) {
                        if (currentValue == element.val()) { 
                            ngModel.$setValidity('unique', unique);
                        }
                    }, function () {
                        ngModel.$setValidity('unique', true);
                    });
            });
        }
    }
}]);