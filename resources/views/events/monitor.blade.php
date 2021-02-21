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
                    Attendance Logs
                    <span class="float-right">
                        <form action="{{ route('events.show.monitor-search', $event->id) }}" method="POST">
                        @csrf
                        
                        <div class="input-group mb-0">
                            <input type="text" class="form-control form-control-sm" name="str" placeholder="Search log" style="z-index:0" value="{{ old('str') ?? request()->get('str') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="button" style="z-index:1"><i class="fas fa-search"></i></button>  
                            </div>
                        </div>
                        </form>     
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="8%">ID</th>
                                    <th>Name</th>
                                    <th width="5%">Type</th>
                                    <th class="text-right" width="30%">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @if(sizeof($clocklogs) > 0)
                                    <?php $i=1;?>
                                    @foreach($clocklogs as $clocklog)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                {{ $clocklog->registration->getFullnameSorted() ?? '' }} / 
                                                {{ $clocklog->registration->office_name ?? '' }} 
                                            </td>
                                            <td>{{ $clocklog->type ?? '' }}</td>
                                            <td class="text-right">{{ date('F d, Y h:ia', strtotime($clocklog->created_at)) ?? '' }}</td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer pt-1 pr-1 pb-0 small">
                    <span class="float-right">{{ $clocklogs->links() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
           @include('events._tools')
        </div>
    </div>
</div>
@endsection
