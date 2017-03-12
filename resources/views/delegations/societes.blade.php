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
                        <h3> @lang('societe.classment_societees_selon_delecgation') {{ $gouvernorat->nom_gouvernorat }} @lang('societe.pour_secteur') {{ $secteur->nom_secteur }} @lang('societe.nnb_societe')  ( {{ $secteur->societes->count() }} )  </h3>
                        <p class="text-muted">@lang('societe.desc_classment_societees_selon_delecgation')</p>
                    </div>



                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div id="list_elements" class="row">
        @foreach ($gouvernorat->delegations as $delegation)
                <div id="id_{{ $delegation->id }}" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-card">
                    <div class="container_element container_display_user">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <a href="{{ route('societes.display.admin', ['id_secteur' => $secteur->id, 'id_delegation' => $delegation->id] ) }}" class="display_objet" dir="rtl">{{ $delegation->nom_delegation }}</a>
                            </div>
                            <div class="toolbar_box"  dir="rtl">
                                <?php $delegation->setSecteur($secteur->id); ?>
                                <a href="{{ route('societes.display.admin', ['id_secteur' => $secteur->id, 'id_delegation' => $delegation->id] ) }}">@lang('societe.nb_societes')  : {{ $delegation->societesViaSecteur->count() }} <i class="fa fa-building-o" aria-hidden="true" ></i></a>
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