@extends('app')

@section('head')
    <div>
        <button id="change-view-btn" class="btn btn-lg btn-primary manage-btn" onclick="changeView()">ניהול</button>
    </div>
@endsection

@section('content')


<div ng-app="app" ng-controller="controller">
    <div id="orders-view" class="container" >
        <div id="orders-state-button-group" class="btn-group btn-group-lg orders-button-group" role="group" aria-label="Large button group">
            <button id="order-state-btn-1" ng-click="changeOrders(1)" type="button" class="btn btn-default button-header open-orders-button active">פתוחות</button>
            <button id="order-state-btn-2" ng-click="changeOrders(2)" type="button" class="btn btn-default button-header">לא שולמו</button>
            <button id="order-state-btn-3" ng-click="changeOrders(3)" type="button" class="btn btn-default button-header">סגורות</button>
        </div>
        {{--<button type="button" class="btn btn-lg btn-default button-manager">נהל</button>--}}
        @include('partials.messages')

        <span ng-repeat="order in toArray(orders) | orderBy : '-order_finish_date' ">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <a class="orderCollapse" role="button" data-toggle="collapse" ng-attr-href="{%'#collapseOrder' + order.id%}" aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">
                            <label ng-bind-html="getOrdererText(order)"></label>
                    </h4>
                    </a>
                </div>

                <div class="collapse panel-collapse" ng-attr-id="{%'collapseOrder' + order.id%}">
                        <div order-table></div>
                </div>
            </div>
         </span>

        <form class="createOrder createForm">
            <div class="form-group">
                <label for="order_finish_date" class="control-label">תאריך סיום</label>
                <div>
                    <input type="datetime-local" ng-model="newOrder.order_finish_date" class="form-control datetime-select-control">
                    <select ng-model="newOrder.am_pm" ng-init="newOrder.am_pm = 'am'" class="select_am_pm">
                        <option value="am" selected>בוקר</option>
                        <option value="pm">ערב</option>
                    </select>
                </div>
                <div>
                    <angucomplete-alt id="selectCustomer" placeholder="הקלד שם לקוח"
                                      pause="100" selected-object="newOrder.selectedCustomer" local-data="customersSelect"
                                      search-fields="first_name,last_name" title-field="first_name,last_name" minlength="0"
                                      input-class="form-control form-control-small selectCustomer" class="productSelect additional_details"/>
                </div>
            </div>
            <br>
            <button class="btn btn-primary" ng-click="createNewOrder(newOrder.selectedCustomer.originalObject.id)">צור הזמנה</button>
        </form>
    </div>

    <div id="manage-view">
        <span ng-repeat="undoneProduct in undoneProducts | orderBy:closestFinishTime">
            <label ng-bind="undoneProduct.amount? undoneProduct.amount + ' ' + getProductNameById(undoneProduct.product_id) : ''"></label>
            <label ng-bind="undoneProduct.amoutFreezed? undoneProduct.amoutFreezed + ' ' + getProductNameById(undoneProduct.product_id) + ' קפוא' : ''"></label>
            <br>
        </span>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        function changeView(){
            if($('#change-view-btn').text() == "הזמנות"){
                $('#change-view-btn').text('ניהול');
                $('#orders-view').show();
                $('#manage-view').hide();
            }
            else{
                $('#change-view-btn').text('הזמנות');
                $('#orders-view').hide();
                $('#manage-view').show();
            }
        }
    </script>
@endsection