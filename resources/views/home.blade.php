@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/cpanel.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container cpanel">
        <div class="row">
            <div class="col-md-2 icon">
                <a href="{{ route('home') }}"><i class="fa fa-tachometer" aria-hidden="true" ></i>
                    <span>@lang('main.dashboard')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('dashboard.dossiers') }}"><i class="fa fa-archive fa-lg" ></i>
                    <span>@lang('main.files')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('societes.index') }}"><i class="fa fa-building-o fa-lg" ></i>
                    <span>@lang('main.syndicats')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-area-chart fa-lg" ></i>
                    <span>@lang('main.stats')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-share-alt fa-lg" ></i>
                    <span>@lang('main.contacts')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-telegram fa-lg" ></i>
                    <span>@lang('main.notifications')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-envelope fa-lg" ></i>
                    <span>@lang('main.mesages')</span>
                </a>
            </div>
            @if( Auth::user()->isAdmin() OR Auth::user()->isObservateurRegional() )
                <div class="col-md-2 icon">
                    <a href="{{ route('users.index') }}"><i class="fa fa-users fa-lg" aria-hidden="true" ></i>
                        <span>@lang('main.users')</span>
                    </a>
                </div>
            @endif
            @if(Auth::user()->isAdmin())
            <div class="col-md-2 icon">
                <a href="{{ route('setting') }}"><i class="fa fa-cogs fa-lg" ></i>
                    <span>@lang('main.configuration') </span>
                </a>
            </div>
            @endif

            <div class="col-md-2 icon">
                <a href="{{ route('logout') }}"onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg" ></i>
                    <span>@lang('main.logout')</span>
                </a>
            </div>
        </div>
    </div>
@endsection
