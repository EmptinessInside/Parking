<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Parking</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link src="{{ asset('css/app.css')}}" rel="stylesheet">
    </head>
    <style>
        .fade-enter-active {
            transition: opacity .5s;
        }
        .fade-leave-active{
            transition: opacity .3s;
        }
        .fade-enter, .fade-leave-to {
            opacity: 0;
        }
    </style>
    <body class="antialiased">
        <header class="shadow pt-4 pr-5 pb-4 pl-5">
            <div class="">
                <div class="d-flex">
                    <div class="w-25 font-weight-bold "><h2>Parking</h2></div>
                    <div class="w-75"></div>
                </div>
            </div>
        </header>
        <div id="app" class="mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8 offset-2">
                        <transition name="fade" mode="out-in">
                            <router-view></router-view>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script src="{{ asset('js/app.js') }}" defer></script>
