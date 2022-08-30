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

<div class="alert-container">

    @foreach ($alerts as $alert)

        <div class="alert-dismissible alert {{ $alert[0] }}">

            <p class="mb-0">{{ $alert[1] }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>

    @endforeach

</div>
