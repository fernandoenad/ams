<div class="card">
    <div class="card-header">
        Administrative Tools
    </div>
    <div class="card-body p-0">
        <ul class="list-group">
            <li class="list-group-item">                   
                <form action="{{ route('events.search') }}" method="POST">
                @csrf
                
                <div class="input-group">
                    <input type="text" class="form-control" name="str" placeholder="Search event" style="z-index:0" value="{{ old('str') ?? request()->get('str') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" style="z-index:1"><i class="fas fa-search"></i></button>  
                    </div>
                </div>
                </form>
            </li>   
            <li class="list-group-item"><a href="{{ route('events') }}">View all events</a></li>
            <li class="list-group-item"><a href="{{ route('events.create') }}">New event</a></li>
            @if(Route::currentRouteName() == 'events.show' ||
                Route::currentRouteName() == 'events.show.search' ||
                Route::currentRouteName() == 'events.show.monitor' ||
                Route::currentRouteName() == 'events.show.monitor-search')
                <li class="list-group-item"></li>
                <li class="list-group-item"><a href="{{ route('registrations.create') }}?id={{ $event->id }}">New registration</a></li>
                <!--
                <li class="list-group-item"><a href="{{ asset('storage/assets/template.xlsx') }}" download>Registration template</a></li>
                <li class="list-group-item"><a href="{{ route('events.create') }}">Upload registrants (bulk)</a></li>
                -->
                <li class="list-group-item"><a href="{{ route('events.show.print-id', $event->id) }}" target="_blank">Print IDs</a></li>
                <li class="list-group-item"><a href="{{ route('events.show.monitor', $event->id) }}">Monitor attendance scans</a></li>
                <li class="list-group-item"><a href="{{ route('events.show.print-appearance', $event->id) }}" target="_blank">Cert. of appearance</a></li>
                <!--
                <li class="list-group-item"><a href="#">Cert. of participation</a></li>
                <li class="list-group-item"><a href="#">Cert. of completion</a></li>
                -->
                <li class="list-group-item"><a href="{{ route('events.show.print-attendance', $event->id) }}" target="_blank">Print attendance</a></li>
            @endif
            
        </ul>
    </div>
</div>