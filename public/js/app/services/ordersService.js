/**
 * Created by User on 21/10/2015.
 */
app.service('ordersService', [ function ($scope) {
    this.getProductNameById = function (id){
        return $scope.products[id].name;
    };
}]);