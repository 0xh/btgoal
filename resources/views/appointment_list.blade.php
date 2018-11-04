@extends('spark::layouts.app')

@section('content')

<div >
    <!-- All checked in Appointments -->
    <div class="panel panel-content panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    All Appointments
                </div> 
                <div class="col-md-6">
                    <a href="/appointment" class="btn btn-default">
                        Add appointment
                    </a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <form method="POST" action="/appointments/delete">
                {{ csrf_field() }}
                <table id="appointment-table" class="table table-borderless m-b-none" >
                    <thead>
                        <th><input class="appointment-box check-all" type="checkbox" name="checked[]"></th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Address</th>
                        <th>Contact</th>
                    </thead>

                    <tbody>
                    @foreach ($apts as $apt)
                        
                        <tr>
                            <td>
                                <input class="appointment-box" type="checkbox" name="checked[]" value="{{ $apt->id }}"> 
                            </td>
                            <td>
                                <div class="btn-table-align">
                                    <a href="/appointment/{{ $apt->id }}">{{ $apt->title }}</a>
                                </div>
                            </td>
                            <!-- Name -->
                            <td>
                                <div class="btn-table-align">
                                    {{ $apt->start_date->format('d-m-y h:ia') }}
                                </div>
                            </td>
                             <!-- Contact -->
                            <td>
                                <div class="btn-table-align">
                                    {{ $apt->address }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-table-align">
                                    {{ $apt->contact_name }}
                                </div>
                            </td>
                           
                        </tr>
                       
                    @endforeach
                    </tbody>
                </table>
                <button id="delete" class="btn btn-default">Delete Appointments</button>
            </form>
            {{ $apts->links() }}
        </div>
    </div>
</div>

@endsection
@section('bottom-scripts')
<script type="text/javascript">
    $(".check-all").change(function(){  //"select all" change 
        $(".appointment-box").prop('checked', $(this).prop("checked")); 
    });
    $('.appointment-box').change(function(){ //".checkbox" change 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false == $(this).prop("checked")){ //if this item is unchecked
            $(".check-all").prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        if ($('.appointment-box:checked').length == $('.appointment-box').length ){
            $(".check-all").prop('checked', true);
        }
    });
</script>
@endsection
