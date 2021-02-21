@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Events Management</h3>
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('message'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Event List
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-md">
                        <small>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Event name</th>
                                    <th width="15%">Date/s covered</th>
                                    <th width="30%">Venue</th>
                                    <th width="15%">Status</th>
                                    <th width="12%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @if(sizeof($events) > 0)
                                    <?php $id=1;?>
                                    @foreach($events as $event)
                                        <tr>
                                            <td><strong>{{ $id++ }}</strong></td>
                                            <td>
                                                <a href="{{ route('events.show', $event->id) }}">
                                                    <strong>{{ $event->name ?? '' }}</strong>
                                                </a>
                                                <br>Event ID: <strong>{{ $event->id ?? '' }}</strong> </td>
                                            <td title="{{ date('Y', strtotime($event->from_date)) ?? '' }}">
                                                {{ date('m/d', strtotime($event->from_date)) ?? '' }} - 
                                                {{ date('m/d', strtotime($event->to_date)) ?? '' }}
                                            </td>
                                            <td>{{ $event->venue ?? '' }}</td>
                                            <td>
                                                {{ $event->registration()->count() }} registrations<br>
                                                {{ $event->getStatus() ?? '' }}
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit" title="Modify event"></i></a>
                                                @if($event->registration()->count() == 0)
                                                    <a href="{{ route('events.destroy', $event->id) }}" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();
                                                        if(confirm('This action deletes the event is IRREVERSIBLE.\n Are you sure you wish to proceed?')){
                                                            document.getElementById('events-delete').submit();
                                                        } else {
                                                            return false;
                                                        }"
                                                        >
                                                        <i class="fas fa-trash-alt" title="Delete event"></i></a>
                                                    <form id="events-delete" action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
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
                    <span class="float-right">{{ $events->links() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
           @include('events._tools')
        </div>
    </div>
</div>
@endsection
