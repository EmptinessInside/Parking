@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
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
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
