@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row toolbar">
            <div class="col-md-6">
                <form>
                    <input type="text" name="search">
                </form>
            </div>
            <div class="col-md-3">
                <div class="search">

                </div>
            </div>
            <div class="col-md-3">
                <a class=""></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 card">
                <p>
                    <span class="nom">LABBOUZ</span>
                    <span class="prenom">Abdelmonam</span>
                </p>
                <p>
                    @lang('users.droits') : <span class="droit">راصد</span>
                </p>
                <p>
                    @lang('users.la_permission_regional') : <span class="detail">أريانة</span>
                </p>

            </div>
        </div>
    </div>
@endsection