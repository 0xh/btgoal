@extends('layouts.no-left')

@section('content')

<div >
    <!-- All checked in Appointments -->
    <div class="panel panel-content panel-default">
        <div class="panel-heading">@if (Request::is('appointment-report')) Appointments with send SMS 
        @else
        Tasks with send SMS
        @endif
        </div>

        <div class="panel-body">
            <table class="table table-borderless m-b-none" >
                <thead>
               
                    <th>Team</th>
                    @if (Request::is('task-report'))
                        <th>Appointment</th>
                    @endif
                    <th>Title</th>
                    <th>Contact</th>
                    <th style="width: 84px">Start Date</th>
                    <th style="width: 84px">End Date</th>
                     <th>SMS</th>
                     <th>In</th>
                    <th style="width: 84px">Checkin Time</th>
                    <th style="width: 84px">Date Created</th>
                    <th>PWD Viewed</th>
                    <th>Carer Viewed</th>
                </thead>

                <tbody>
                @foreach ($apts as $apt)
                    
                    <tr>
                    <td>
                        <div class="btn-table-align">
                            {{ $apt->team->name }}
                        </div>
                    </td>
                    @if (Request::is('task-report'))
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->appointment->title}}
                            </div>
                        </td>
                    @endif
                        <!-- Name -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->title }}
                            </div>
                        </td>
                         <!-- Contact -->
                        <td>
                            <div class="btn-table-align">
                            @if (isset($apt->contact->name))
                                {{ $apt->contact->name }}
                            @endif
                            </div>
                        </td>
                        <!-- Start Date -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->start_date->format('d-m-y h:ia') }}
                            </div>
                        </td>
                        <!-- End Date -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->end_date->format('d-m-y h:ia') }}
                            </div>
                        </td>
                        <!-- SMS  -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->send_sms }}
                            </div>
                        </td>
                        <!-- Checkin  -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->checkin }}
                            </div>
                        </td>
                       
                        <!-- Check intime -->
                        <td>
                       
                        @if (isset($apt->checkin_datetime))
                            <div class="btn-table-align">
                               
                                {{ $apt->checkin_datetime->format('d-m-y h:ia') }}
                            </div>
                        @endif
                        </td>
                        <!-- Date Created -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->created_at->format('d-m-y h:ia') }}
                            </div>
                        </td>
                        <!-- PWD Count -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->pwd_count }}
                            </div>
                        </td>
                        <!-- Carer Count -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->carer_count }}
                            </div>
                        </td>
                       
                    </tr>
                   
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
