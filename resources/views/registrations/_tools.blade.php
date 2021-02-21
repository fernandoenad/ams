<div class="card">
    <div class="card-header">
        Administrative Tools
    </div>
    <div class="card-body p-0">
        <ul class="list-group">
            <li class="list-group-item">
                <form action="{{ route('registrations.search') }}" method="POST">
                @csrf
                
                <div class="input-group">
                    <input type="text" class="form-control" name="str" placeholder="Search registrant" style="z-index:0" value="{{ old('str') ?? request()->get('str') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" style="z-index:1"><i class="fas fa-search"></i></button>  
                    </div>
                </div>
                </form>
            </li>   
            <li class="list-group-item"><a href="{{ route('registrations') }}">View all</a></li>
            <li class="list-group-item"><a href="{{ route('registrations.create') }}">New registration</a></li>
        </ul>
    </div>
</div>