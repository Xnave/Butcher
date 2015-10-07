/**
 * Created by User on 05/10/2015.
 */
var app = angular.module('app', ["angucomplete-alt"], function($interpolateProvider) {
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
});

//app.config(['$routeProvider',
    //function($routeProvider) {
    //    $routeProvider.
    //        when('/phones', {
    //            templateUrl: 'partials/phone-list.html',
    //            controller: 'PhoneListCtrl'
    //        }).
    //        when('/phones/:phoneId', {
    //            templateUrl: 'partials/phone-detail.html',
    //            controller: 'PhoneDetailCtrl'
    //        }).
    //        otherwise({
    //            redirectTo: '/phones'
    //        });
    //}]);

app.directive('orderTable', function() {
    return {
        templateUrl: '/partials/Orders'
    }
});
