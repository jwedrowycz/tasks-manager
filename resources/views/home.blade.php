@extends('layouts.app')

@section('title', 'Strona główna')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista zadań') }}</div>
                <tasks></tasks>
                <div class="col-md-4 mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal">Dodaj zadanie</button>
                    <create-task></create-task>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection
