@extends('app')

@section('navbar-items')
    <li><a href="./">View all</a></li>
@endsection


@section('content')

    <h1 class="create-title"> {!! 'צור '  .ucfirst($modelHebrewName)  !!} </h1>

    {!! Form::open(array('action' => array(ucfirst($modelName).'Controller@store'), 'class' => 'createForm', 'files'=>true)) !!}
    @include('model-views.'.$modelName.'.form')
    {!! Form::submit('צור '.ucfirst($modelHebrewName), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    @include('partials.messages')

@endsection