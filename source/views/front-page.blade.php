@extends('app')

@push('app-open')
    @navbar
    @endnavbar
    {{-- @high
    @endhigh --}}
@endpush

@push('app-close')
    {{-- @include('components.footer') --}}
    @footer
    @endfooter
@endpush

@push('main-content')
    <h1>{{ $test }}</h1>
@endpush
