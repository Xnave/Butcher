/**
 * Created by User on 01/10/2015.
 */
app.controller('controller', ['$scope', '$http', '$interval', '$sce', function($scope, $http, $interval, $sce) {
    $scope.customersSelect = customers;
    $scope.customers = toMap(customers);
    $scope.customer = customers[Object.keys(customers)[0]];

    $scope.units = units;
    $scope.unitsMap = toMap(units);
    $scope.products = toMap(products);

    $scope.openOrders = toMap(openOrders);
    $scope.doneNonPaidOrders = toMap(doneNonPaidOrders);
    $scope.paidOrders = toMap(paidOrders);

    $scope.orders = $scope.openOrders;
    $scope.newOrder = {};
    $scope.changeOrderInstance = {};
    var freezed_string = "קפוא";

    $scope.toArray = function (map) {
        var array_values = [];

        for (var key in map) {
            array_values.push(map[key]);
        }
        return array_values;
    };

    $scope.getProductNameById = function (id){
        return $scope.products[id].name;
    };
    $scope.getAmountString = function(orderItem){
        if(orderItem.amount_product_units){
            return orderItem.amount_product_units + ' ' + $scope.unitsMap[1].name;
        }
        else if(orderItem.amount_kilo){
            return orderItem.amount_kilo + ' ' + $scope.unitsMap[2].name;
        }
        else{
            return orderItem.amount_packages + ' ' + $scope.unitsMap[3].name;
        }
    };

    function getUnitName(orderItem){
        if(orderItem.amount_product_units){
            return $scope.unitsMap[1].name;
        }
        else if(orderItem.amount_kilo){
            return $scope.unitsMap[2].name;
        }
        else{
            return $scope.unitsMap[3].name;
        }
    }

    $scope.getCustomerPriceString = function (product_id, customer_id) {
        return $scope.getProductNameById(product_id) + ' ' + $scope.getCustomerPrice(product_id, customer_id) + '₪';

    };

    $scope.getCustomerPrice = function (product_id, customer_id) {
        var price;
        $.each($scope.customers[customer_id].customPrices, function (index, customPrice) {
            if(customPrice.product_id == product_id){
                price = customPrice.special_price;
            }
        });
        if(!price){
            $.each($scope.products, function (index, product) {
                if(product.id == product_id){
                    price = product.price;
                }
            });
        }
        return price;
    };

    $scope.updateAmountByUnits = function(orderItem){
        if(orderItem.units == 1){
            orderItem.amount_product_units = orderItem.amount;
        }
        else if(orderItem.units == 2){
            orderItem.amount_kilo = orderItem.amount;
        }
        else{
            orderItem.amount_packages = orderItem.amount;
        }
    };

    $scope.deleteOrder = function(id){
        $http.delete('/Customers/Orders/' + id, {_token: getToken()}).
            then(function(response){
                delete $scope.orders[id];
            });
    };

    $scope.doneOrder = function (id) {
        if($scope.ordersState == OPEN_ORDERS_STATE) {
            $http.post('/Customers/Orders/done', {id: id}).
                then(function (response) {
                        $scope.doneNonPaidOrders[id] = $scope.orders[id];
                        delete $scope.orders[id];
                });
        } else{
            $http.post('/Customers/Orders/done/undo', {id: id}).
                then(function (response) {
                    $scope.openOrders[id] = $scope.orders[id];
                    delete $scope.orders[id];
                });
        }

    };

    $scope.paidOrder = function (id) {
        if($scope.ordersState == PAID_ORDERS_STATE){
            $http.post('/Customers/Orders/paid/undo', {id: id}).
                then(function (response) {
                    $scope.doneNonPaidOrders[id] = $scope.orders[id];
                    delete $scope.orders[id];
                });
        }
        else {
            $http.post('/Customers/Orders/paid', {id: id}).
                then(function (response) {
                    $scope.paidOrders[id] = $scope.orders[id];
                    delete $scope.orders[id];
                });
        }
    };

    $scope.isDoneDisabled = function (order_id) {
        var disabled = true;

            var order = $scope.orders[order_id];
            if(order.orderItems && order.orderItems.length > 0){

                //all items done
                disabled = false;

                $.each(order.orderItems, function (index, orderItem) {
                    if(orderItem.done == null || orderItem.done == false){
                        disabled = true;
                        return false;
                    } else{
                        changeStyle(orderItem.id, '#2ADC2A');
                    }
                });
            }
        //no items
        return disabled;
    };

    $scope.checkDoneable = function (order_id) {
        return $scope.isDoneDisabled(order_id);
    };
    $scope.checkPaidable = function (order_id) {
        return $scope.isDoneDisabled(order_id);
    };


        $scope.findProductByName = function(name){
        for (var key in $scope.products) {
            if($scope.products[key].name == name){
                return $scope.products[key].id;
            }
        }
    };

    $scope.saveOrderItem = function(orderItem){
        $http.post('/Customers/Orders/'+ orderItem.order_id +'/OrderItems/add', orderItem).
            then(function(response){
                orderItem.id = response.data[0].id;
            });
    };

    $scope.deleteOrderItem = function(orderItemId){
        $http.delete('/Customers/Orders/OrderItems/' + orderItemId, {_token: getToken()});
    };

    $scope.newOrderItems = [];
    $.each($scope.orders, function (key, order) {
        $scope.newOrderItems[order.id] = {'units': 2};
    });

    $scope.addRow = function(newOrderItem){
        newOrderItem.product_id = $scope.findProductByName(newOrderItem.product_name);
        var alreadyExists = false;
        $.each($scope.orders[newOrderItem.order_id].orderItems, function (idx, orderItem) {
           if(orderItem.product_id == newOrderItem.product_id){
               alreadyExists = true;
           }
        });
        if(alreadyExists) {
            alert('מוצר כבר קיים בהזמנה');
            return;
        }

        newOrderItem.units = parseInt(newOrderItem.units);

        if(newOrderItem.amount == 0) {
            newOrderItem.amount = 1; // x = 1
            newOrderItem.units  = 1; // x item
        }
        $scope.updateAmountByUnits(newOrderItem);

        var order_id = newOrderItem.order_id;
        if($scope.orders[order_id].id == newOrderItem.order_id){
            var clone = jQuery.extend(true, {}, newOrderItem);
            $scope.saveOrderItem(clone);
            if(!$scope.orders[order_id].orderItems){
                $scope.orders[order_id].orderItems = {};
            }
            $scope.orders[order_id].orderItems.push(clone);
            $scope.newOrderItems[order_id] = {order_id: order_id, units: "1"};
        }
    };


    $scope.totalPrice = function (order_id, customer_id) {
        var total = 0;
        $.each($scope.orders[order_id].orderItems, function (index, orderItem) {
            if(orderItem.done && orderItem.weight){
                total += orderItem.weight * $scope.getCustomerPrice(orderItem.product_id, customer_id);
            }
        });

        return 'סכ"ה: ' + total + '₪';
    };

    $scope.displayTotalCalculation = function (order_id, customer_id) {
        var total = 0;
        var sub_total;
        var display = "";

        $.each($scope.orders[order_id].orderItems, function (index, orderItem) {
            if(orderItem.done && orderItem.weight){
                sub_total = orderItem.weight * $scope.getCustomerPrice(orderItem.product_id, customer_id);
                //display += orderItem.weight + "\n X " + $scope.getCustomerPrice(orderItem.product_id, customer_id) +
                //    ' ' + $scope.getProductNameById(orderItem.product_id) + '\n= ' + sub_total + '\n';
                display += orderItem.weight + "\n X "
                        + $scope.getCustomerPrice(orderItem.product_id, customer_id)
                        + " (" + $scope.getProductNameById(orderItem.product_id) + ")" + '\n= ' + sub_total + '\n';
                total += sub_total;
            }
        });

        display += 'סך הכל: ' + total + '₪';
        alert(display);
    };

    $scope.removeOrderItem = function (orderItem, orderId) {
        var orderItemId = orderItem.id;
        for (var j = 0, len2 = $scope.orders[orderId].orderItems.length; j < len2; j++) {
            if ($scope.orders[orderId].orderItems[j].id == orderItemId) {
                $scope.orders[orderId].orderItems.splice(j, 1);
                $scope.deleteOrderItem(orderItemId);
                if(!$scope.orders[orderId].deletedItems) $scope.orders[orderId].deletedItems = {};
                $scope.orders[orderId].deletedItems[orderItemId] = orderItem;
                return;
            }
        }
    };

    $scope.changeOrder = function (order) {
        var radio_selected = $('#changeOrderModal' + order.id).find('input:radio:checked');
        if(radio_selected.val() == 'date'){
            $http.post('/Customers/Orders/changeDate', {order_id: order.id,
                order_finish_date: $scope.getDateMoment24h($scope.changeOrderInstance.order_finish_date, $scope.changeOrderInstance.am_pm).format(),
                '_token': getToken()}).
                then(function (response) {
                    order.order_finish_date = formatDate($scope.getDateMoment24h($scope.changeOrderInstance.order_finish_date, $scope.changeOrderInstance.am_pm).toDate());
                });
        } else if(radio_selected.val() == 'items'){
            $('#changeOrderModal' + order.id).find('input:checkbox:checked').each(function (index, element) {
                var item_id = $(element).attr('item-id');
                $http.post('/Customers/Orders/recoverItem', { item_id: item_id,
                    '_token': getToken()}).
                    then(function (response) {
                        console.log(item_id);
                        order.orderItems.push(order.deletedItems[item_id]);
                        delete order.deletedItems[item_id];
                    });
            });
        }
    };

    $scope.computeRemainingTime = function (finish_date) {
        var date = parseDate(finish_date);
        var curr = new Date();

        var past = false;
        if (date < curr) {
            tmp = curr;
            curr = date;
            date = tmp;

            past = true;
        }

        var msec = date - curr;
        var dd = Math.floor(msec / 1000 / 60 / 60 / 24);
        msec -= dd * 1000 * 60 * 60 * 24;
        var hh = Math.floor(msec / 1000 / 60 / 60);
        msec -= hh * 1000 * 60 * 60;
        var mm = Math.floor(msec / 1000 / 60);

        if (dd != 0) {
            dd = dd + "<br> ימים, ";
        }
        else {
            dd = "";
        }
        if (hh != 0) {
            hh = '<br>' + hh + " שעות <br>";
        }
        else {
            hh = "";
        }

        var label = '<label class=' + (past? "timePast" : "timeFuture") + '><br>';
        label += past ? "ללפני: " : "לעוד: ";
        label += dd + hh + mm + " דקות" + "<labe>";

        label = $sce.trustAsHtml(label);
        return label;
    };

    $scope.getOrdererText = function(order, additionalText){
        additionalText = additionalText || "";
        var text = $scope.customers[order.orderer_id].first_name + ' ' + $scope.customers[order.orderer_id].last_name + ' ';

        if($scope.ordersState == PAID_ORDERS_STATE){
            var order_finish_date = moment(order.order_finish_date);
            var today = moment();
            if(order_finish_date.diff(today, 'days') == 0){
                text += 'היום בשעה ';
                text += moment(order.order_finish_date).format('HH:mm');
            } else if(order_finish_date.diff(today, 'days') == 1){
                text += 'מחר בשעה ';
                text += moment(order.order_finish_date).format('HH:mm');
            } else{
                text += moment(order.order_finish_date).format('l HH:mm');
            }

        } else{
            text += $scope.computeRemainingTime(order.order_finish_date);
        }
        text = text.split('<br>').join(' ');
        text = $sce.trustAsHtml(additionalText + text);
        return text;
    };

    $scope.createNewOrder = function (customer_id) {
        //$http.defaults.headers.post['X-CSRF-TOKEN'] = getToken();
        $http.post('/Customers/Orders/store', {orderer_id: customer_id,
            order_finish_date: $scope.getDateMoment24h($scope.newOrder.order_finish_date, $scope.newOrder.am_pm).format(),
            '_token': getToken()}).
            then(function (response) {
                var id = response.data;
                $scope.openOrders[id] = ({id: id,
                    orderer_id: customer_id,
                    order_finish_date: formatDate($scope.getDateMoment24h($scope.newOrder.order_finish_date, $scope.newOrder.am_pm).toDate()),
                    orderItems: []});
            },
            function (response) {
                $('body').html(response.data);
            });
    };

    $scope.getDateMoment24h = function(date, am_pm){
        if(am_pm == 'pm'){
            return moment(date).add('12', 'hours');
        }
        return moment(date);
    };

    $scope.updateItem = function (orderItem) {
        $http.post('/Customers/Orders/OrderItem/UpdateWeight', {id: orderItem.id, weight: orderItem.weight,
            details: orderItem.additional_details})
            .then(function (response) {
                if(orderItem.weight){
                    orderItem.done = true;
                    changeStyle(orderItem.id, '#2ADC2A');
                }
                else{
                    orderItem.done = false;
                    changeStyle(orderItem.id, '#FF3E3E');
                }
            });
    };

    $scope.markDone = function (orderItem) {
        if(orderItem.weight){
            orderItem.done = true;
        }
    };


    changeStyle = function (id, color) {
        $.each($('[id="rowid-'+id+'"]').find('td'), function (index, element) {
            $(element).attr('style', 'background-color:' + color + ' !important');
        });
    };

    $scope.promptAddDetails = function(orderItem){
        orderItem.additional_details = prompt('הכנס פרטים נוספים', orderItem.additional_details);
    };

    $scope.inputChangeHandler = function(str) {
        if (str.length < minlength) {
            clearResults();
        }
        else if (str.length === 0 && minlength === 0) {
            $scope.searching = false;
            showAll();
        }

        if ($scope.inputChanged) {
            str = $scope.inputChanged(str);
        }
        return str;
    };

    $scope.changeOrderDate = function(order_id){
        changeDateFieldsVisibality(order_i);
    };

    function changeDateFieldsVisibality(order_id){
        //show, show, change class: primary
    }

    $scope.changeOrders = function(state){
        $('#orders-state-button-group').children('button')
            .removeClass('open-orders-button non-paid-orders-button done-orders-button active');
        var btn = $('#order-state-btn-' + state);
        switch (state){
            case 1:
                btn.addClass('open-orders-button active');
                //$http.get('/allOpenOrders').then(changeOrdersByResponse);
                $scope.ordersState = OPEN_ORDERS_STATE;
                $scope.orders = $scope.openOrders;
                break;
            case 2:
                btn.addClass('non-paid-orders-button active');
                //$http.get('/allDoneNonPaidOrders').then(changeOrdersByResponse);
                $scope.ordersState = DONE_ORDERS_STATE;
                $scope.orders = $scope.doneNonPaidOrders;
                break;
            case 3:
                btn.addClass('done-orders-button active');
                //$http.get('/allPaidOrders').then(changeOrdersByResponse);
                $scope.ordersState = PAID_ORDERS_STATE;
                $scope.orders = $scope.paidOrders;
                break;
        }
    };
    OPEN_ORDERS_STATE = 1;
    DONE_ORDERS_STATE = 2;
    PAID_ORDERS_STATE = 3;
    $scope.ordersState = OPEN_ORDERS_STATE;

    $scope.changeOrderButtonsStateText = function () {
        if($scope.ordersState == PAID_ORDERS_STATE){
            $('.btn-order-paid').each(function(index, element){
                $(element).addClass('btn-danger');
                $(element).text('לא שולם');
            });
        }
        //changeDoneButtonsText
        if($scope.ordersState == PAID_ORDERS_STATE || $scope.ordersState == DONE_ORDERS_STATE){
            $('.btn-order-done').each(function(index, element){
                $(element).addClass('btn-danger');
                $(element).text('לא הסתיים');
            });
        }
    };

    $scope.isOrdersStateOpen = function () {
        return $scope.ordersState == OPEN_ORDERS_STATE;
    };

    function changeOrdersByResponse(response) {
        $scope.response = response.data;
        $scope.orders = toMap(response.data);
    }

    $scope.populateDeletedItems = function (order) {
        $http.get('Customers/Orders/' + order.id + '/deletedItems')
            .then(function (response) {
                order.deletedItems = toMap(response.data);
            });
    };

    $scope.getIsFreezedText  = function (orderItem) {
        return orderItem.is_freeze_allowed ? " קפוא" : "";
    };

    $scope.getOrderItemFinishDateMS = function (orderItem) {
        return $scope.orders[orderItem.order_id].order_finish_date;
    };

    $scope.getUndoneProducts = function(){
        var undoneProducts = {};

        var undoneOrderItems = [];
        $.each($scope.openOrders, function(idx, order){
            $.each(order.orderItems, function (idx, orderItem) {
                if(orderItem.weight == 0 || !orderItem.weight){
                    undoneOrderItems.push(orderItem);
                }
            })
        });

        $.each(undoneOrderItems, function(idx, orderItem){
            if(!undoneProducts[orderItem.product_id]){
                undoneProducts[orderItem.product_id] =
                    {product_id: orderItem.product_id, amounts: {}, amoutFreezed: 0, orderItems: [],
                     closestFinishTime: $scope.orders[orderItem.order_id].order_finish_date};
            }

            var key;
            var amount, is_freezed = false;
            if(orderItem.amount_product_units){
                key = $scope.unitsMap[1].name;
                amount = orderItem.amount_product_units;
            }
            else if(orderItem.amount_kilo){
                key = $scope.unitsMap[2].name;
                amount = orderItem.amount_kilo;
            }
            else{
                key = $scope.unitsMap[3].name;
                amount = orderItem.amount_packages;
            }

            if(orderItem.is_freeze_allowed){
                key += " " + freezed_string;
                is_freezed = true;
            }

            if(!undoneProducts[orderItem.product_id].amounts[key]){
                undoneProducts[orderItem.product_id].amounts[key] = {amount: amount, freezed: is_freezed};
            } else{
                undoneProducts[orderItem.product_id].amounts[key].amount += amount;
            }

            undoneProducts[orderItem.product_id].orderItems.push(orderItem);

            if(moment($scope.orders[orderItem.order_id].order_finish_date).isAfter(moment(undoneProducts[orderItem.product_id].closestFinishTime))){
                $scope.orders[orderItem.order_id].order_finish_date = undoneProducts[orderItem.product_id].closestFinishTime;
            }
        });

        return undoneProducts;
    };

    $scope.undoneProducts = $scope.getUndoneProducts();

    //$scope.newOrder.order_finish_date = new Date(new Date().toISOString().substring(0, 10));
    $.each($scope.orders, function (index, order) {
        $.each(order.orderItems, function (index, orderItem) {
            $scope.markDone(orderItem);
        });
    });

    $scope.getCustomerFullName = function (orderItem) {
        return $scope.customers[$scope.openOrders[orderItem.order_id].orderer_id].first_name
            + " " + $scope.customers[$scope.openOrders[orderItem.order_id].orderer_id].last_name;
    };

    $scope.getRowId = function (id){
        return 'rowid-' + id;
    };

    $interval(function () {
    }, 20000)
}]);

app.filter('freezedFilter', function(){

    return function(undoneProducts, query){
        var result = {};
        for (var i in undoneProducts){
            result[i] = undoneProducts[i];
        }

        Object.keys(result).forEach(function (key) {
            if(result[key].freezed != query){
                delete result[key];
            }
        });
        return result;
    };
});

function formatDate(date){
    return date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate() + ' ' +
        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
}

function parseDate(input) {
    var parts = input.split('-');
    var parts2 = parts[2].split(' ');
    var parts3 = parts2[1].split(':');

    // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
    return new Date(parts[0], parts[1]-1, parts2[0], parts3[0], parts3[1]); // Note: months are 0-based
}

function getToken(){
    return $('#token-input').attr('content');
}
