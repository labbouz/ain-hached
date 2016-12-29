@extends('layouts.app')

@section('header')
    <link href="/css/pages/users.css" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <h3> @lang('users.users')  </h3>
                    <p class="text-muted">@lang('users.info_list_users')</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 container-card">
                <a href="javascript:void(0)" class="add box">
                    <span class="fa fa-user-plus"></span>
                    <span class="text">@lang('main.add_user')</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <input type="search" class="form-control" id="input-search" placeholder="Rechercher..." autocomplete="off">
                </form>
            </div>
        </div>
        <div class="row">

            @for ($i = 0; $i < 10; $i++)
                <div class="col-md-3 container-card">
                    <div class="text-right card box">
                            <span class="nom">LABBOUZ</span>
                            <span class="prenom">Abdelmonam</span>
                    </div>
                </div>

            @endfor


        </div>
    </div>
@endsection