@extends('layouts.app')

@section('content')
@if(Auth::check())
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

@endsection
