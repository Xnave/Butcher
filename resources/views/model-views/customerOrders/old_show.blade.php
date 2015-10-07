@extends('app')

@section('head')
    <link rel="stylesheet" href="/css/table.css">
@endsection

@section('content')
    <?php
        Form::macro('date', function($name, $value = null, $options = array()) {
            $input =  '<input type="datetime-local" name="' . $name . '" value="' . $value . '"';

            foreach ($options as $key => $value) {
                $input .= ' ' . $key . '="' . $value . '"';
            }

            $input .= '>';

            return $input;
        });
    ?>

    <div class="container ">
        @include('partials.messages')
        <h1 class="create-title">הזמנה ל{!! $customer->first_name .' '. $customer->last_name !!} </h1>
        <p>{!! $customer->address !!} , {!! $customer->phone_number !!}</p>

        @foreach($orders as $order)
            <table class="table-hide-first layout display responsive-table table-buttons col-xs-3">
                <thead>
                    <tr>
                        <th>
                            <label class="date-label time-left-label" data-value="{{$order->order_finish_date}}"></label>
                        </th>
                        <th>מוצר</th>
                        <th>כמות</th>
                        <th>האם קפוא</th>
                        <th>משקל</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        {!! Form::open(['method' => 'DELETE', 'action' => ['OrdersController@deleteOrderItem', -1], 'onsubmit' => 'this.parentNode.remove();', 'class' => 'removeOrderItemForm']) !!}
                        <td>
                            {!! Form::button('<span class="glyphicon glyphicon-minus"></span>', ['type' => 'submit', 'class' => 'btn btn-info btn-xs table-button', 'id' => 'deleteOrderItemButton']) !!}
                        </td>

                        <td id="productName"></td>
                        <td id="productUnits"></td>
                        <td><input type="checkbox" name="is_freeze_allowed"</td>
                        {!! Form::close() !!}
                        <td><input type="number"></td>
                    </tr>
                    @foreach($order->orderProducts()->get() as $orderProducts)
                        <tr>
                            {!! Form::open(['method' => 'DELETE', 'action' => ['OrdersController@deleteOrderItem', $orderProducts->pivot->id], 'onsubmit' => 'this.parentNode.remove();', 'class' => 'removeOrderItemForm']) !!}
                            <td>
                                {!! Form::button('<span class="glyphicon glyphicon-minus"></span>', ['type' => 'submit', 'class' => 'btn btn-info btn-xs table-button', 'id' => 'deleteOrderItemButton']) !!}
                            </td>

                            <td id="productName">
                                {!! $orderProducts->name  !!}
                            </td>

                            <td id="productUnits">
                                @if(!is_null($orderProducts->pivot->amount_product_units))
                                    {!! $orderProducts->pivot->amount_product_units  !!}
                                    <label for="units">יחידות</label>
                                @elseif(!is_null($orderProducts->pivot->amount_kilo))
                                    {!! $orderProducts->pivot->amount_kilo  !!}
                                    <label for="units">קילו</label>
                                @else
                                    {!! $orderProducts->pivot->amount_packages  !!}
                                    <label for="units">חבילות</label>
                                @endif
                            </td>
                            <td>
                                <input type="checkbox" name="is_freeze_allowed"
                                @if($orderProducts->pivot->is_freeze_allowed)
                                    checked
                                @endif >
                            </td>
                            {!! Form::close() !!}
                            <td><input type="number"></td>
                        </tr>
                    @endforeach

                    <tr id="addOrderItemRow">
                        {!! Form::open(['action' => ['OrdersController@storeOrderItem', $order->id], 'onsubmit' => 'addRow($(this).parents(\'table\')); updateProductId();', 'id' => 'addOrderItem']) !!}
                        <td>
                        {!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['type' => 'submit', 'class' => 'btn btn-primary btn-xs table-button']) !!}
                        </td>
                        <td>
                            {!! Form::hidden('product_id', null, ['id' => 'product_id']) !!}
                            {!! Form::text(null, null, ['class' => 'productSelect', 'list' => 'product_list'])!!}
                            <datalist id="product_list">
                                @foreach(\App\Models\Product::lists('id', 'name') as $product_id => $product_name)
                                    <option data-value="{!! $product_name !!}" value="{!! $product_id !!}"></option>
                                @endforeach
                            </datalist>
                        </td>
                        <td> {!! Form::input('number', 'amount', null, ['name' => 'amount', 'class' => 'table-input']) !!}
                            <select name="units">
                                <option value="amount_product_units">יחידות</option>
                                <option value="amount_kilo" selected>קילו</option>
                                <option value="amount_packages">חבילות</option>
                            </select>
                        </td>
                        <td> {!! Form::checkbox('is_freeze_allowed', 1, false) !!}</td>
                        {!! Form::close() !!}
                    </tr>
                </tbody>
            </table>

    {!! Form::open(['method' => 'DELETE',
                              'action' => ['OrdersController@destroy', $order->id, false],
                              'onsubmit' => "return confirm('אתה בטוח?')"]) !!}
    {!! Form::submit('מחק הזמנה', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    @endforeach
    </div>

    {!! Form::open(['action' => ['OrdersController@store', $customer->id], 'class' => 'createOrder createForm', 'id' => 'createOrderForm']) !!}
    <div class="form-group">
        {!! Form::label('first_name', 'תאריך סיום', ['class' => 'control-label']) !!}
        {!! Form::date('order_finish_date', date("d/m/y H:i:s"), ['class' => 'form-control']) !!}
    </div>
    <br>
    {!! Form::submit('צור הזמנה', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        function updateProductId() {
            var x = $('.productSelect');
            var val = $('#product_list').find('option[value="' + x.val() + '"]');
            $('#product_id').val(val.attr('data-value'));
        }
    </script>

    <script src="http://malsup.github.com/jquery.form.js"></script>

    <script>
        function addRow(table)
        {
            var dummyRow = table.find('tbody')[0];  //get the table
            var node= dummyRow.rows[0].cloneNode(true);    //clone the previous node or row
            node.removeAttribute('style');
            var addOrderRow = document.getElementById('addOrderItemRow');
            $('[name="is_freeze_allowed"]', node).prop('checked', $('[name="is_freeze_allowed"]', addOrderRow).prop('checked'));
            $('#productName', node).text($('.productSelect', addOrderRow).val());
            $('#productName', node).attr('data-id', $('#product_list', addOrderRow).find('[value="' + $('.productSelect', addOrderRow).val() + '"]').attr('data-value'));

            var amount = $('[name="amount"]', addOrderRow).val();
            if(amount == 0) {
                $('#productUnits', node).text('1 יחידות')
            }
            else{
                $('#productUnits', node).text(amount + ' ' + $('[name="units"] option:selected', addOrderRow).text())
            }


            $(node).children('td').find('button').prop('disabled', true);
            dummyRow.insertBefore(node, addOrderRow);   //add the node or row to the table

            $(node).children('form').attr('method', 'DELETE');
            updateRemoveOrderItemFormAJAX();
            $('#table').find('tbody tr:nth-last-child(2) button').on('click', function(){
                $(node).children('form').submit();
            });
        }

        function getAction(url, id){
            return url.substr(url, url.indexOf('-1')) + id + url.substr(url.indexOf('-1')+2);
        }

        $(document).ready(function() {
            $('#addOrderItem').ajaxForm(
                    {
                        success: function(response){
//                            var response = JSON.parse(request.responseText);

                            $.each($('.table').find('tbody tr td#productName'), function(index, element){
                                if(element.getAttribute('data-id') == response[0].product_id){
                                    form = $(element).parent().children('form');
                                    form.attr('action', getAction(form.attr('action'), response[0].id));
                                    $(element).parent().children('td').find('button').prop('disabled', false);
                                }
                            });
                        },
                        error: function(request, status, error) {
                             location.reload();
                        }
                    }
            );
        });

        function updateRemoveOrderItemFormAJAX() {
            $('.removeOrderItemForm').ajaxForm(
                    {
                        data: { '_method': 'DELETE', '_token': $($('#table').find('tbody tr td#productName').first().parent().children('input')[1]).val() },
                        type: 'post',
                        error: function(request, status, error) {
                            alert('תגיד לנווה שיש לו באג #1');
                        }
                    }
            );
        }
        updateRemoveOrderItemFormAJAX();
        $('.table-hide-first').find('tbody tr:first').hide();

        function updateDateLabel() {
            $.each($('.time-left-label'), function (index, element) {
                var date = parseDate($(element).attr('data-value'));
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
                    dd = dd + " ימים, ";
                }
                else {
                    dd = "";
                }

                var prefix = past ? "עברו:" : "נותרו:";
                prefix += '<br>';
                label = $(element).html(prefix + dd + hh + " שעות <br>" + mm + " דקות");
                if (past) {
                    label.css('color', 'red');
                }
            });
        }

        function parseDate(input) {
            var parts = input.split('-');
            var parts2 = parts[2].split(' ');
            var parts3 = parts2[1].split(':');

            // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
            return new Date(parts[0], parts[1]-1, parts2[0], parts3[0], parts3[1]); // Note: months are 0-based
        }

        updateDateLabel();
        setInterval(updateDateLabel, 10000);
    </script>
@endsection
