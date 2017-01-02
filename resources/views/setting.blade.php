@extends('layouts.app')

@section('header')
    <link href="/css/pages/cpanel.css" rel="stylesheet">
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
                <a href="{{ route('secteurs.index') }}"><i class="fa fa-cubes fa-lg" aria-hidden="true" ></i>
                    <span>@lang('main.secteurs')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('home') }}"><i class="fa fa-university fa-lg" ></i>
                    <span>@lang('main.delegations')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-hand-rock-o fa-lg" ></i>
                    <span>@lang('main.structures_syndicales')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-fire fa-lg" ></i>
                    <span>@lang('violations.les_violations')</span>
                </a>
            </div>
            <div class="col-md-2 icon">
                <a href="{{ route('users.index') }}"><i class="fa fa-map-signs fa-lg" ></i>
                    <span>@lang('main.moves')</span>
                </a>
            </div>

        </div>
    </div>
@endsection