@extends('app')

@section('content')
    <div id="wrapper" class="">
        @include('partials.messages')
        @foreach($models as $model)

            <div class="thumbnail model-tumbnail col-xs-4 col-md-2">
                @include('model-views.'.$modelDetails, ['$model' => $model])

                <div>
                    <a href="{{ action(ucfirst($modelName).'Controller@edit', $model->id) }}" class="btn btn-primary">Edit {{ucfirst($modelName)}}</a>
                    {!! Form::open(['method' => 'DELETE',
                                    'action' => array(ucfirst($modelName).'Controller@destroy', $model->id),
                                    'class' => 'right',
                                    'onsubmit' => "return confirm('Are you sure?')"]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
        @include('partials.admin-sidebar')
    </div>
@endsection