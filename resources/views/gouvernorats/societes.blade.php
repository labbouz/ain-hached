@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/display_societes.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index" dir="rtl">
                        <a class="retour_setting" href="{{ route('societes.index') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.syndicats')"></i></a>
                        <h3> @lang('societe.classment_societees_selon_gouvernorat') {{ $secteur->nom_secteur }} @lang('societe.nnb_societe')  ( {{ $secteur->societes->count() }} )  </h3>
                        <p class="text-muted">@lang('societe.desc_classment_societees_selon_gouvernorat')</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
        @foreach ($gouvernorats as $gouvernorat)
                <div id="id_{{ $gouvernorat->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
                    <div class="container_element container_display_user">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <a href="{{ route('societes_region.admin', ['id_secteur' => $secteur->id, 'id_gouvernorat' => $gouvernorat->id] ) }}" class="display_objet" dir="rtl">{{ $gouvernorat->nom_gouvernorat }}</a>
                            </div>
                            <div class="toolbar_box"  dir="rtl">

                                <a href="{{ route('societes_region.admin', ['id_secteur' => $secteur->id, 'id_gouvernorat' => $gouvernorat->id] ) }}">{{ $gouvernorat->nb_societes }} <i class="fa fa-building-o" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('societe.nb_societes')  : {{ $gouvernorat->nb_societes }}" ></i></a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_societes.js') }}"></script>
@endsection