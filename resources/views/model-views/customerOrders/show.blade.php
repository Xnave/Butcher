@extends('app')

@section('content')

    <div class="container" ng-app="app" >
        @include('partials.messages')

        <span ng-controller="controller">
            <h1 class="create-title">הזמנות ל<a href="{%'/Customers/' + customer.id%}"><span class="create-title" ng-bind="customer.first_name + ' ' + customer.last_name"></span></a></h1>
            <p ng-bind="customer.address + ', ' + customer.phone_number"></p>

            <span ng-repeat="order in orders">
                <div order-table></div>
            </span>

            <form class="createOrder createForm">
                <div class="form-group">
                    <label for="order_finish_date" class="control-label">תאריך סיום</label>
                    <input type="datetime-local" ng-model="newOrder.order_finish_date" class="form-control">
                </div>
                <br>
                <button class="btn btn-primary" ng-click="createNewOrder(customer.id)">צור הזמנה</button>
            </form>
        </span>
    </div>
@endsection
