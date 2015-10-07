@extends('app')

@section('navbar-items')
        <li><a href="../">View all</a></li>
@endsection


@section('content')

        <h1 class="create-title">Edit {{ substr($modelName, 0, -1) }}</h1>

        {!! Form::model($model, array('action' => array(ucfirst($modelName).'Controller@update', $model->id), 'method' => 'PUT'
                                    , 'class' => 'createForm', 'files'=>true)) !!}
        @include('model-views.'.$modelName.'.form')
        {!! Form::submit('Update '.substr($modelName, 0, -1), ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}

        @include('partials.messages')

@endsection