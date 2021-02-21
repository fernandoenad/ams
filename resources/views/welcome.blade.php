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
                                    <select type="text" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
                                        class="form-control" placeholder="ID Barcode" aria-label=""  aria-describedby="submit-button" autofocus>
                                        <option value="">Select event to be monitored</option>
                                        @foreach($events as $event)
                                            <option value="{{ route('clocks.show', [$event->id, 'In']) }}">
                                                {{ $event->name }} 
                                                ({{ date('M d', strtotime($event->from_date)) }} - {{ date('M d, Y', strtotime($event->to_date)) }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <br><br><br><br>                                   
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="hero-right-wrapper">
                <div class="hero-right-title">
                    <h5 class="text-right">Bohol Attendance Management System V1.0</h5>
                    <p class="text-right">Developed by Fernando B. Enad</p>
                </div>
            </div>         
        </div>
    </body>

</html>
