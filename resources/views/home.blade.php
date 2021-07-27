@extends('layouts.app')

@section('title', 'Strona główna')

@section('content')
    @include('layouts.alerts')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista zadań') }}</div>
                @auth
                    <task-component>
                    </task-component>
                @else
                    <p class="ml-3 mt-3">{{ __('Musisz być zalogowany żeby dodać i przeglądać zadania') }}</p>
                    <a class="ml-3 mb-3" href="#" data-toggle="modal" data-target="#loginModal">{{ __('Zaloguj') }}</a>
                    @include('modals.login')
                @endauth
            </div>
        </div>
    </div>
@endsection
