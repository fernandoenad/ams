@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Events Management - New Event</h3>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <form method="POST" action="{{ route('events.store') }}">
                @csrf

                <div class="card-header">
                    New Event
                </div>
                <div class="card-body">
                

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-9">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="from_date" class="col-md-2 col-form-label text-md-right">{{ __('From') }}</label>

                        <div class="col-md-9">
                            <input id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}" autocomplete="from_date" autofocus>

                            @error('from_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="to_date" class="col-md-2 col-form-label text-md-right">{{ __('To') }}</label>

                        <div class="col-md-9">
                            <input id="to_date" type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date" value="{{ old('to_date') }}" autocomplete="to_date">

                            @error('to_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="venue" class="col-md-2 col-form-label text-md-right">{{ __('Venue') }}</label>

                        <div class="col-md-9">
                            <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" value="{{ old('venue') }}" autocomplete="venue">

                            @error('venue')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('events') }}" class="btn btn-default btn-sm">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm float-right">
                        {{ __('Save event') }}
                    </button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            @include('events._tools')
        </div>
    </div>
</div>
@endsection
