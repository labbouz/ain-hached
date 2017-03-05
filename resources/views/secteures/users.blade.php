@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/secteurs.css')}}" rel="stylesheet">
@endsection

@section('page-title')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm12 col-xs-12">
                <div class="page-title">
                    <div id="header_index">
                        <a class="retour_setting" href="{{ route('users.index') }}"><i class="fa fa-reply" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="@lang('main.users')"></i></a>
                        <h3> {{ $titre_label }}  </h3>
                        <p class="text-muted">{{ $role->name }} : {{ $role->description }}</p>
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
                                <span class="edit" dir="rtl">{{ $secteure->nom_secteur }}</span>
                            </div>
                            <div class="toolbar_box"  dir="rtl">

                                <a href="{{ route('users.display', ['id_role' => $role->id, 'id_inicateur' => $secteure->id] ) }}">
                                    @lang('users.nb_observateurs')  : {{ $secteure->users_roles->count() }} <i class="fa fa-users" aria-hidden="true" @if($secteure->users_roles->count() > 0 ) data-toggle="tooltip" data-placement="top" title="
                                @foreach ($secteure->users_roles as $roleuser)

                                    @if($secteure->users_roles->first() == $roleuser)
                                        {{ $roleuser->user->name }}
                                    @else
                                            - {{ $roleuser->user->name }}
                                    @endif

                                    @endforeach
                             @endif
                                            "></i>
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
    <script src="{{ asset('js/display_users.js') }}"></script>
@endsection