@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/cpanel.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container cpanel">
        <div class="row">
            <div class="col-md-9">
                <p class="text-right notacces">
                    <span>@lang('main.errors')</span>
                </p>
            </div>

            <div class="col-md-3 icon">
                <p class="text-center notacces">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                </p>
            </div>

        </div>
    </div>
@endsection
