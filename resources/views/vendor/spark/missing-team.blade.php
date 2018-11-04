@extends('spark::layouts.app')

@section('content')

<div class="panel panel-content panel-warning">
    <div class="panel-heading">Where's Your {{ ucfirst(Spark::teamString()) }}?</div>

    <div class="panel-body">
        It looks like you're not part of any {{ Spark::teamString() }}! You can create one in your
        <a href="/settings#/{{ str_plural(Spark::teamString()) }}">settings</a>.
    </div>

</div>
@endsection
