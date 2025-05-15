@extends('BaseSite.BaseViews.layouts.main', $_mainParams)

@section('content')
    @include('BaseSite.BaseViews.layouts.contentleft', ['_mainParams' => $_mainParams, '_view' => $_view])
@endsection