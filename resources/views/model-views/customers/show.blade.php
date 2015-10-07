@extends('app')

@section('head')
    <link rel="stylesheet" href="/css/table.css">
@endsection

@section('content')

    <div class="container">
        <h1 class="create-title">{!! $customer->first_name .' '. $customer->last_name !!} </h1>
        <p>{!! $customer->address !!}</p>
        <p>{!! $customer->phone_number !!}</p>

        <table class="layout display responsive-table table-buttons">
            <tr>
                <th></th>
                <th>מוצר</th>
                <th>מחיר מיוחד</th>
            </tr>
            @foreach($customerPrices as $spericalPriceProduct)
                <tr>
                    {!! Form::open(['action' => ['CustomersController@deleteSpecialPrice', $spericalPriceProduct->pivot->id]]) !!}
                    <td>
                        {!! Form::button('<span class="glyphicon glyphicon-minus"></span>', ['type' => 'submit', 'class' => 'btn btn-info btn-xs table-button']) !!}
                    </td>
                    <td>{!! $spericalPriceProduct->name  !!} </td>
                    <td>{!! $spericalPriceProduct->pivot->special_price  !!} </td>
                    {!! Form::close() !!}
                </tr>
            @endforeach

            <tr>
                {!! Form::open(['action' => ['CustomersController@storeSpecialPrice', $customer->id]]) !!}
                <td>
                {!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['type' => 'submit', 'class' => 'btn btn-primary btn-xs table-button']) !!}
                </td>
                <td>{!! Form::select('product_id', \App\Models\Product::lists('name', 'id'), null, ['id' => 'productSelect'])!!} </td>
                <td> {!! Form::input('number', 'specialPrice', null, null) !!} </td>
                {!! Form::close() !!}
            </tr>
        </table>

        {!! Form::open(['method' => 'DELETE',
                                    'action' => ['CustomersController@destroy', $customer->id, false],
                                    'onsubmit' => "return confirm('אתה בטוח?')"]) !!}
        {!! Form::submit('מחק לקוח', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
    @include('partials.messages')

@endsection

@section('scripts')
    @endsection
