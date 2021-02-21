<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    </head>
    <body>
        <div class="overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="{{ asset('storage/assets/bg.mp4') }}" type="video/mp4">
        </video>
        <div class="hero">
            <div class="masthead" id="app">
                <div class="masthead-bg"></div>
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-12 my-auto">
                            <div class="masthead-content text-white py-5 py-md-0">
                                <div class="text-center">
                                    <img src="{{ asset('storage/assets/logo.png') }}" style="width: 150px">
                                    <br><br>
                                    <h3 class="mb-3">Clock {{ strtoupper($type) ?? '' }}!</h3>
                                    <p class="mb-5">Flash your barcoded ID over the scanner<br> to get started...</p>
                                    <form action="{{ route('clocks.show.clock', [$event->id, $type]) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-newsletter">
                                        <input type="text" name="registration_id" id="registration_id" class="form-control" placeholder="ID Barcode" required autofocus>
                                        <input type="hidden" name="type" id="type" value="{{ $type ?? ''}}" class="form-control">

                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="submit-button">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                    <br><br><br><br>                                   
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="hero-right-wrapper">
                <div class="hero-right-title">
                    <h5 class="text-right">{{ $event->name ?? '' }}</h5>
                    <p class="text-right">{{ $event->venue ?? '' }} | 
                        {{ date('M d', strtotime($event->from_date)) ?? '' }} - {{ date('M d, Y', strtotime($event->from_date)) ?? '' }}</p>
                </div>

                @if(isset($registration))
                    <div class="hero-right-content">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="">Welcome!</h5>
                                <br>
                                <h4><strong>{{ $registration->getFullname() ?? '' }}</strong></h4>
                                <h6>{{ $registration->position ?? '' }}</h6>
                                <h6>{{ $registration->office_name ?? '' }}</h6>
                                <br>                               
                            </div>                        
                            <div class="div-md-3">
                                <img src="{{ asset('storage/assets/no-avatar.jpg') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <br>
                                <h3>{{ date('F d, Y h:i A', strtotime($clocklog->created_at)) ?? '' }} ({{ $clocklog->type ?? '' }})</h3>
                                <p class="text-success text-center">Your attendance has been logged.</p>
                            </div>
                        </div>
                    @else
                        @if (session('message'))
                            <div class="hero-right-error">
                                <h3 class="text-danfer">{{ session('message') }}</h3>
                            </div>
                        @endif

                    @endif
                </div>
            </div>

            

            <div class="social-icons">
                
                <ul class="list-unstyled text-center mb-0">
                    <li class="list-unstyled-item">
                        <a href="{{ route('clocks.show.clock', [$event->id, 'In']) }}" title="Clock In">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    </li>
                    <li class="list-unstyled-item">
                        <a href="{{ route('clocks.show.clock', [$event->id, 'Out']) }}" title="Clock Out">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </li>
                </ul>
            </div>            
        </div>
    </body>

</html>
