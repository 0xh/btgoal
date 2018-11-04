@extends('spark::layouts.app')
@section('content')
<!-- Current contacts -->
<div class="panel panel-content panel-default">
    <div class="panel-heading">Organisations</div>
    <div class="panel-body">
        <table class="table table-borderless m-b-none" >
            <thead>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th class="samerow">Operations</th>
            </thead>
            
            <tbody>
            @foreach ($organisations as $organisation)

                <tr >
                    <!-- Name -->
                    <td>
                        <div class="btn-table-align">
                            {{ $organisation->name }}
                        </div>
                    </td>
                    
                    <td>
                        <div class="btn-table-align">
                            {{ $organisation->phone }}
                        </div>
                    </td>
                    <td>
                        <div class="btn-table-align">
                            {{ $organisation->email }}
                        </div>
                    </td>
                    <td>
                        <div class="btn-table-align">
                            {{ $organisation->address }}
                        </div>
                    </td>
                    <!-- Delete Button -->
                    <td>
                       <form class="form-inline" action="/organisations/{{ $organisation->id }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type='submit' class="{{ $class or 'btn btn-danger' }}" value="{{ $value or 'delete' }}">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </form>
                        <a href="/organisations/{{ $organisation->id }}/edit">
                        <span type="submit" class="btn btn-primary">
                        Edit
                        </span>
                         </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection