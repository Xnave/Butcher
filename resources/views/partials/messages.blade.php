<?php $success = Session::get('success'); ?>
<?php $fail = Session::get('fail');?>

{{--@if(isset($success))--}}
    {{--<span class="success">{!!$success !!}</span>--}}
{{--@endif--}}
@if(isset($fail))
    <span class="failed">{!!$fail !!}</span>
@endif
@if(isset($errors))
<span class="failed"> {!! Html::ul($errors->all()) !!} </span>
@endif