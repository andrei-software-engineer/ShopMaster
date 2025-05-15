@extends('platform::dashboard')

@section('title')
    {{ __($name) }}
@endsection

@section('description')
    {{ __($description) }}
@endsection

@section('controller')
    base
@endsection

@section('navbar')
    @foreach($commandBar as $command)
        <li class="{{ !$loop->first ? 'ms-2' : ''}}">
            {!! $command !!}
        </li>
    @endforeach
@endsection

@section('content')
    <div id="modals-container">
        @stack('modals-container')
    </div>

        {!! $layouts !!}

    <div data-controller="filter">
        <form id="filters" autocomplete="off" data-action="filter#submit"></form>
    </div>
@endsection
