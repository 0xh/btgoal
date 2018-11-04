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
                    <th>Image Added</th>
                </thead>

                <tbody>
                @foreach ($apts as $apt)
                    
                    <tr>
                    <td>
                        <div class="btn-table-align">
                            {{ $apt->teams_name }}
                        </div>
                    </td>
                        <!-- Name -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->appointments_title }}
                            </div>
                        </td>
                         <!-- Contact -->
                        <td>
                            <div class="btn-table-align">
                            @if (isset($apt->contact_title))
                                {{ $apt->contact_title }}
                            @endif
                            </div>
                        </td>
                        <!-- Start Date -->
                        <td>
                            <div class="btn-table-align">
                                {{ Carbon\Carbon::createFromTimestamp($apt->appointments_start_date)->format('d-m-y h:ia') }}
                            </div>
                        </td>
                        <!-- End Date -->
                        <td>
                            <div class="btn-table-align">
                            {{ Carbon\Carbon::createFromTimestamp($apt->appointments_end_date)->format('d-m-y h:ia') }}
                            </div>
                        </td>
                        <!-- SMS  -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->appointments_send_sms }}
                            </div>
                        </td>
                        <!-- Checkin  -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->appointments_checkin }}
                            </div>
                        </td>
                       
                        <!-- Check intime -->
                        <td>
                       
                        @if (isset($apt->appointments_checkin_datetime))
                            <div class="btn-table-align">
                               {{ Carbon\Carbon::createFromTimestamp($apt->appointments_checkin_datetime)->format('d-m-y h:ia') }}
                            </div>
                        @endif
                        </td>
                        <!-- Date Created -->
                        <td>
                            <div class="btn-table-align">
                            {{ Carbon\Carbon::createFromTimestamp($apt->appointments_created_at)->format('d-m-y h:ia') }}
                            </div>
                        </td>
                        <!-- PWD Count -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->appointments_pwd_count }}
                            </div>
                        </td>
                        <!-- Carer Count -->
                        <td>
                            <div class="btn-table-align">
                                {{ $apt->appointments_carer_count }}
                            </div>
                        </td>

                        <td>
                            <div class="btn-table-align">
                                @if (isset($apt->photos_photo))
                                    Yes
                                @endif
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
