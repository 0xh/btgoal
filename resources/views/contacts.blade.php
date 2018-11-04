@extends('spark::layouts.app')
@section('content')
<!-- Current contacts -->
<div class="panel panel-content panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                Contacts
            </div>
            <div class="col-md-6">
                <a href="/contacts/create" class="btn btn-default">Add person</a>
                <a class="btn btn-default" href="/organisations/create">Add place or organisation</a>
            </div>
        </div>
        
    </div>
    <div class="panel-body">
        <table class="table table-borderless m-b-none" >
            <thead>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <!--        <th class="samerow">Operations</th> -->
            </thead>
            
            <tbody>
                @foreach ($contacts as $contact)
                <tr >
                    <!-- Name -->
                    <td>
                        <div class="btn-table-align">
                            @if (class_basename($contact) == "Contact")
                                <a href="/contacts/{{$contact->id}}/edit">{{ $contact->name }}</a>
                            @else
                                <a href="/organisations/{{$contact->id}}/edit">{{ $contact->name }}</a>
                            @endif
                        </div>
                    </td>
                    
                    <td>
                        <div class="btn-table-align">
                            {{ $contact->phone }}
                        </div>
                    </td>
                    <td>
                        <div class="btn-table-align">
                            {{ $contact->address }}
                        </div>
                    </td>
                    <!-- Delete Button -->
                    <!--                     <td>
                        <form class="form-inline" action="/contacts/{{ $contact->id }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type='submit' class="{{ $class or 'btn btn-danger' }}" value="{{ $value or 'delete' }}">
                            <i class="fa fa-trash-o"></i>
                            </button>
                        </form>
                        <a href="/contacts/{{ $contact->id }}/edit">
                            <span type="submit" class="btn btn-primary">
                                Edit
                            </span>
                        </a>
                    </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection