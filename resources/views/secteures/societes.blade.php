@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/display_societes.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('home') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.dashboard')"></i></a>
                        <h3> @lang('societe.classment_societees_selon_secteur')  </h3>
                        <p class="text-muted">@lang('societe.desc_classment_societees_selon_secteur')</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
        @foreach ($secteures as $secteure)
                <div id="id_{{ $secteure->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
                    <div class="container_element container_display_user">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <a href="{{ route('societes_secteur.admin', ['id_secteur' => $secteure->id] ) }}" class="display_objet" dir="rtl">{{ $secteure->nom_secteur }}</a>
                            </div>
                            <div class="toolbar_box"  dir="rtl">

                                <a href="{{ route('societes_secteur.admin', ['id_secteur' => $secteure->id] ) }}"> {{ $secteure->societes->count() }} <i class="fa fa-building" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('societe.nb_societes')  : {{ $secteure->societes->count() }}" ></i></a>
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