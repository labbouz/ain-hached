@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/gouvernorats.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('setting') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.configuration')"></i></a>
                        <h3> @lang('delegations.delegations')  </h3>
                        <p class="text-muted">@lang('delegations.description_delegations')</p>
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
                    <div class="container_element">

                        <div class="edit_card card box">
                            <div class="label_elemen">
                                <span class="edit" dir="rtl">{{ $gouvernorat->nom_gouvernorat }}</span>
                            </div>
                            <div class="toolbar_box"  dir="rtl">

                                <a href="{{ route('delegations.display',$gouvernorat->id ) }}">
                                    @lang('delegations.n_delegations')  : {{ $gouvernorat->delegations->count() }} <i class="fa fa-university" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="
                                @foreach ($gouvernorat->delegations as $delegation)

                                    @if($gouvernorat->delegations->first() == $delegation)
                                        {{ $delegation->nom_delegation }}
                                    @else
                                            - {{ $delegation->nom_delegation }}
                                    @endif

                                    @endforeach"></i>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>

            @endforeach


        </div>
    </div>

@endsection


@section('footer')
    <script src="{{ asset('js/display_gouvernorats.js') }}"></script>
@endsection