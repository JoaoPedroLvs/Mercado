@extends('layouts.main', [
    'pageTitle' => 'Dashboard'
])

@section('content')

<div class="page page-welcome">

    <div class="page-header">

        <h1>Navegue na aba acima</h1>

    </div>

    <div class="page-body">

        @include('components.alert')

        {{-- @dd(Auth::user()->role) --}}

    </div>

</div>

@endsection
