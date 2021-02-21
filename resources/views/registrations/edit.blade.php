@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Registrations Management - Modify Registration</h3>
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('message'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <form method="POST" action="{{ route('registrations.update', $registration->id) }}">
                @csrf
                @method('PATCH')

                <div class="card-header">
                    Modify Registration
                </div>
                <div class="card-body">
                
                <div class="form-group row">
                        <label for="event_id" class="col-md-2 col-form-label text-md-right">{{ __('Event') }}</label>

                        <div class="col-md-9">
                            <select disabled id="event_id" type="text" class="form-control @error('event_id') is-invalid @enderror" name="event_id" value="{{ old('event_id') }}" autocomplete="event_id" autofocus>
                                <option value="">Select</option>
                                <?php $events = App\Models\Event::where('from_date', '>=', date('Y-m-d', strtotime(today())))
                                    ->orderBy('name', 'asc')->get();?>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" @if(old('event_id') == $event->id || $event->id == $registration->event_id) {{ 'selected' }} @endif>{{ $event->name }} ({{ date('M d', strtotime($event->from_date)) }} - {{ date('M d, Y', strtotime($event->to_date)) }})</option>
                                    @endforeach
                            </select>
                            @error('event_id')

                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-9">
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $registration->email ?? '' }}" autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="last_name" class="col-md-2 col-form-label text-md-right">{{ __('Last name') }}</label>

                        <div class="col-md-9">
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $registration->last_name ?? '' }}" autocomplete="last_name">

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="first_name" class="col-md-2 col-form-label text-md-right">{{ __('First name') }}</label>

                        <div class="col-md-9">
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? $registration->first_name ?? '' }}" autocomplete="first_name">

                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="middle_name" class="col-md-2 col-form-label text-md-right">{{ __('Middle name') }}</label>

                        <div class="col-md-9">
                            <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') ?? $registration->middle_name ?? '' }}" autocomplete="middle_name">

                            @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contact_no" class="col-md-2 col-form-label text-md-right">{{ __('Contact #') }}</label>

                        <div class="col-md-9">
                            <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') ?? $registration->contact_no ?? '' }}" autocomplete="contact_no">

                            @error('contact_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="position" class="col-md-2 col-form-label text-md-right">{{ __('Position') }}</label>

                        <div class="col-md-9">
                            <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') ?? $registration->position ?? '' }}" autocomplete="position">

                            @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="office_name" class="col-md-2 col-form-label text-md-right">{{ __('District / Office') }}</label>

                        <div class="col-md-9">
                            <input id="office_name" type="text" class="form-control @error('office_name') is-invalid @enderror" name="office_name" value="{{ old('office_name') ?? $registration->office_name ?? '' }}" autocomplete="office_name">

                            @error('office_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                   
                </div>

                <div class="card-footer">
                    <a href="{{ route('registrations') }}" class="btn btn-default btn-sm">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm float-right">
                        {{ __('Update registration') }}
                    </button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            @include('registrations._tools')
        </div>
    </div>
</div>
@endsection
