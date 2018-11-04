@extends('spark::layouts.app')
@section('content')
<home :user="user" inline-template>
<div>
    <!-- Application Dashboard -->
    <div class="panel panel-content panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    Dashboard
                </div>
                <div class="col-md-6">
                    <a href="/appointment" class="btn btn-default">
                        Add appointment
                    </a>
                    <a href="/appointment/list" class="btn btn-default">
                        View all
                    </a>
                </div>
            </div>
        </div>
        
        <div class="panel-body">
            <full-calendar :event-sources="eventSources" v-on:event-drop="dropEvent" v-on:event-selected="getEvent" v-on:event-created="createEvent" v-on:event-resize="resizeEvent"></full-calendar>
        </div>
    </div>
</div>
</home>
@endsection