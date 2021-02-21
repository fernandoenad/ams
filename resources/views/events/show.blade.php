@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Events Management- Event Profile </h3>
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('message'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Event Profile for <strong>Event ID# {{ $event->id ?? '' }}</strong>
                    <span class="float-right"> <a href="{{ route('events') }}"><i class="fas fa-arrow-circle-left"></i> Back to events</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="{{ route('events.show', $event->id) }}"><i class="fas fa-sync-alt"></i> Refresh page</a></span>
                </div>
                <div class="card-body p-0">
                    <div class="media border p-3">
                        <img src="{{ asset('storage/assets/logo.png') }}" alt="Logo" class="mr-3 mt-0 rounded-circle" style="width:60px;">
                        <div class="media-body">
                            <h4>{{ $event->name ?? '' }}</h4>
                            <p>
                                {{ date('M d', strtotime($event->from_date)) ?? '' }} - {{ date('M d', strtotime($event->to_date)) ?? '' }} | 
                                {{ $event->venue ?? '' }} <br>
                                <strong>{{ $event->registration->count() ?? '' }} Registration(s) <i><small>as of {{ date('M d, Y h:ia', strtotime(now())) }}</small></i></strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    Registration List
                    <span class="float-right">
                        <form action="{{ route('events.show.search', $event->id) }}" method="POST">
                        @csrf
                        
                        <div class="input-group mb-0">
                            <input type="text" class="form-control form-control-sm" name="str" placeholder="Search registrant" style="z-index:0" value="{{ old('str') ?? request()->get('str') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="button" style="z-index:1"><i class="fas fa-search"></i></button>  
                            </div>
                        </div>
                        </form>     
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="8%">ID</th>
                                    <th>Name</th>
                                    <th width="20%">Contact</th>
                                    <th width="20%">Position & Office</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Confirm</th>
                                    <th width="12%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @if(sizeof($registrations) > 0)
                                    <?php $i=1;?>
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td><strong>{{ $registration->getFullnameSorted() ?? '' }}</strong><br>Reg ID: <strong>{{ $registration->id ?? '' }}</strong></td>
                                            <td>{{ $registration->contact_no ?? '' }}<br>{{ $registration->email ?? '' }}</td>
                                            <td>{{ $registration->position ?? '' }}<br>{{ $registration->office_name ?? '' }}</td>
                                            <td>{{ $registration->getStatus() ?? '' }}</td>
                                            <td>
                                                @if($registration->status == 1)
                                                    <a href="{{ route('registrations.confirm', [$registration->id, 2]) }}" onClick="return confirm('This action will confirm the registration. \nDo you wish to proceed?')">Confirm</a>
                                                @else
                                                    <a href="{{ route('registrations.confirm', [$registration->id, 1]) }}" onClick="return confirm('This action will undo the previous confirmation the registration. \nDo you wish to proceed?')">Undo</a>
                                                @endif
                                            </td>
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
                                    <tr><td colspan="7">No record found.</td></tr>
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
           @include('events._tools')
        </div>
    </div>
</div>
@endsection
