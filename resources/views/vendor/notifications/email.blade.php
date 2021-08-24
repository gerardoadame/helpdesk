<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        @php
            include(public_path().'/css/app.css');
        @endphp
    </style>


</head>
<body style="background-color: #f6f6f6">
    <div class="container-fluid p-5 is-flex is-justify-content-center is-align-items-center is-flex-direction-column">

        <div class="block is-flex is-justify-content-center is-align-items-center">
            <figure class="image is-32x32 mr-2">
                <img src="{{ asset('img/logo.png') }}">
            </figure>
            <p class="title is-4">HiDesk</p>
        </div>

        <div class="box has-text-centered" style="max-width: 570px;">

            <div class="block">
                <!-- Greetings -->
                <p class="title is-size-5 field">{{ $greeting }}</p>

                @foreach ($introLines as $line)
                    <p class="field">{{ $line }}</p>
                @endforeach

                <a class="button is-primary" href="{{ $actionUrl }}">{{ $actionText }}</a>
            </div>

            <p class="block">{{ $line }}</p>

            <p class="has-text-grey has-text-weight-semibold">{{ $salutation }}</p>
            <small class="has-text-grey">Este enlace para restablecer la contraseña expirará en 60 minutos.</small>

            <hr>

            <small class="has-text-grey">Si tienes problemas para hacer clic en el botón {{ $actionText }}, copie y pegue este URL en su navegador web: <br>
                {{ $actionUrl }}
            </small>
        </div>
    </div>
</body>
</html>
