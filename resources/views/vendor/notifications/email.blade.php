<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        @php
            include public_path() . '/css/email.css';
        @endphp
    </style>

</head>

<body style="background-color: #f6f6f6">
    <center class="py-3">

        <img class="mb-3" height="32" width="116" href="{{ asset('img/logo-w-text_small.png') }}">

        <div class="box has-text-centered has-text-centered" style="max-width: 570px;">

            <div class="block">
                <!-- Greetings -->
                <p class="title is-size-5 field has-text-centered">{{ $greeting }}</p>

                @foreach ($introLines as $line)
                    <p class="field">{{ $line }}</p>
                @endforeach

                <a class="button is-primary" href="{{ $actionUrl }}">{{ $actionText }}</a>
            </div>

            <p class="has-text-grey has-text-weight-semibold has-text-centered">{{ $salutation }}</p>
            <small class="has-text-grey">Este enlace para restablecer la contraseña expirará en 60 minutos.</small>

            <hr>

            <small class="has-text-grey">Si tienes problemas para hacer clic en el botón {{ $actionText }}, copie
                y pegue este URL en su navegador web: <br>
                {{ $actionUrl }}
            </small>
        </div>
    </center>
</body>

</html>
