@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Registrations Management</h3>
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('message'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Registration List
                    <span class="float-right"><a href="{{ route('events') }}">Back to events</a></span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th>Name</th>
                                    <th width="20%">Contact</th>
                                    <th width="20%">Position & Office</th>
                                    <th width="10%">Status</th>
                                    <th width="12%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @if(sizeof($registrations) > 0)
                                    <?php $i=1;?>
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ $registration->getFullname() ?? '' }}<br>
                                                <a href="{{ route('events.show', $registration->event_id) }}">
                                                    <strong>{{ $registration->event->name ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td>{{ $registration->contact_no ?? '' }}<br>{{ $registration->email ?? '' }}</td>
                                            <td>{{ $registration->position ?? '' }}<br>{{ $registration->office_name ?? '' }}</td>
                                            <td>{{ $registration->getStatus() ?? '' }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit" title="Modify registration"></i></a>
                                                <a href="{{ route('registrations.destroy', $registration->id) }}" class="btn btn-danger btn-sm"
                                                    onclick="event.preventDefault();
                                                    if(confirm('This action deletes the registration and is IRREVERSIBLE.\n Are you sure you wish to proceed?')){
                                                        document.getElementById('registrations-delete').submit();
                                                    } else {
                                                        return false;
                                                    }">
                                                    <i class="fas fa-trash-alt" title="Delete registration"></i></a>
                                                
                                                <form id="registrations-delete" action="{{ route('registrations.destroy', $registration->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div>
                <div class="card-footer pt-1 pr-1 pb-0 small">
                    <span class="float-right">{{ $registrations->links() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
           @include('registrations._tools')
        </div>
    </div>
</div>
@endsection
