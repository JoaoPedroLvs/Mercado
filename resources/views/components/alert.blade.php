@php

    $alertTypes = [
        "success" => "alert-success",
        "error" => "alert-danger",
        "warning" => "alert-warning",
    ];

    $alerts = [];

    foreach ($alertTypes as $type => $class) {
        if(Session::has($type)) {

            array_push($alerts, [$class, Session::get($type)]);

        }
    }
    if (count($errors) > 0) {
        array_push($alerts, [$alertTypes["error"], $errors->all()[0]]);
    }
@endphp

@if (count($alerts) > 0)

    <div class="alert-container p-4">

        @foreach ($alerts as $alert)

            <div class="alert alert-dismissible fade show {{ $alert[0] }}">

                <p class="mb-0">{{ $alert[1] }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

        @endforeach

    </div>

@endif
