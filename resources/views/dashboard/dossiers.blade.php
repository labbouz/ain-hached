@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/pages/cpanel.css') }}" rel="stylesheet">
@endsection



@section('content')
    <div class="container cpanel">
        <div class="row">
            <div class="col-md-3 icon">
                <a href="{{ route('home') }}"><i class="fa fa-tachometer fa-lg" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_dashboard')" ></i>
                    <span>@lang('main.dashboard')</span>
                </a>
            </div>
            <div class="col-md-3 icon">
                <a href="{{ route('dossier.create') }}"><i class="fa fa-plus-circle fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_add_file')" ></i>
                    <span>@lang('dossier.add_file')</span>
                </a>
            </div>
            <div class="col-md-3 icon">
                <a href="{{ route('new.dossiers') }}"><i class="fa fa-bullhorn fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_files_non_lus')" ></i>
                    <span>@lang('dossier.files_non_lus')</span>
                </a>
            </div>
            <div class="col-md-3 icon">
                <a href="{{ route('important.dossiers') }}"><i class="fa fa-thermometer-full fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_files_important')" ></i>
                    <span>@lang('dossier.files_important')</span>
                </a>
            </div>
            <div class="col-md-3 icon">
                <a href="{{ route('mes.dossiers') }}"><i class="fa fa-folder-open fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_myfiles')" ></i>
                    <span>@lang('dossier.myfiles')</span>
                </a>
            </div>
            <div class="col-md-3 icon">
                <a href="{{ route('dossier.add') }}"><i class="fa fa-archive fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_files_show')" ></i>
                    <span>@lang('dossier.files_show')</span>
                </a>
            </div>

            <div class="col-md-3 icon">
                <a href="{{ route('dossier.add') }}"><i class="fa fa-free-code-camp fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_exactions')" ></i>
                    <span>@lang('dossier.exactions')</span>
                </a>
            </div>

            <div class="col-md-3 icon">
                <a href="{{ route('dossier.add') }}"><i class="fa fa-search fa-lg" data-toggle="tooltip" data-placement="top" title="@lang('dossier.description_search_dossier')" ></i>
                    <span>@lang('dossier.search_dossier')</span>
                </a>
            </div>

        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

        });
    </script>
@endsection
