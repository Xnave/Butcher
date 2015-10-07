@extends('app')

@section('head')
    <link rel="stylesheet" href="/css/table.css">
@endsection

    @section('content')

        <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" class="form-control search-input" placeholder= "שם לקוח">
                <button type="submit" class="btn btn-default btn-middle">חפש</button>
            </div>
        </form>

        <div class="container">
            <table id="table" class="layout display responsive-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>שם פרטי</th>
                        <th>שם משפחה</th>
                        <th>כתובת</th>
                        <th>מס טלפון</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($customers as $customer)
                        <tr data-customerid="{{ $customer->id }}">
                            <td><a href="/Customers/{!! $customer->id  !!}/Orders"> צור הזמנה</a></td>
                            <td>{!! $customer->first_name  !!} </td>
                            <td>{!! $customer->last_name  !!} </td>
                            <td>{!! $customer->address  !!} </td>
                            <td>{!! $customer->phone_number  !!} </td>
                            <td><a href="/Customers/{!! $customer->id  !!} "> עדכן לקוח</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

@section('scripts')
    {{--<script src="/js/table/table.js"></script>--}}
    <script>
        (function(document) {
            'use strict';

            var LightTableFilter = (function(Arr) {

                var _input;

                function _onInputEvent(e) {
                    _input = e.target;
                    var table = document.getElementsByClassName('responsive-table');
                    Arr.forEach.call(table, function(table) {
                        Arr.forEach.call(table.tBodies, function(tbody) {
                            Arr.forEach.call(tbody.rows, _filter);
                        });
                    });
                }

                function _filter(row) {
                    var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
                    row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
                }

                return {
                    init: function() {
                        var inputs = document.getElementsByClassName('search-input');
                        Arr.forEach.call(inputs, function(input) {
                            input.oninput = _onInputEvent;
                        });
                    }
                };
            })(Array.prototype);

            document.addEventListener('readystatechange', function() {
                if (document.readyState === 'complete') {
                    LightTableFilter.init();
                }
            });

        })(document);
    </script>
@endsection

@endsection
