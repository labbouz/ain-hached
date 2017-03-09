@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/cpanel.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container cpanel">
        <div class="row">
            <div class="col-md-9">
                <p class="text-right notacces">
                    <span>@lang('main.not_acces')</span>
                </p>
            </div>

            <div class="col-md-3 icon">
                <p class="text-center notacces">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                </p>
            </div>

        </div>
    </div>
@endsection
