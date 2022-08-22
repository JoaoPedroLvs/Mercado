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

        <div class="alert {{ $alert[0] }}">

            <p>{{ $alert[1] }}</p>

        </div>

    @endforeach

</div>
