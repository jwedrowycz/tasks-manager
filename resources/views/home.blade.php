@extends('layouts.app')

@section('title', 'Strona główna')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <tasks></tasks>
            </div>
        </div>
    </div>
</div>
@endsection
