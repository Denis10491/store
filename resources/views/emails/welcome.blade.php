<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FakeStore</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100;300;400;600;800&display=swap" rel="stylesheet">

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.19.4/dist/css/uikit.min.css"/>

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.19.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.19.4/dist/js/uikit-icons.min.js"></script>

    @vite('resources/assets/css/app.css')
</head>
<body>

<div id="app">
    @component('emails.ui.card', ['classes' => 'uk-text-center'])
        <h1>Welcome!</h1>
        <p>Now you are with us! Order products without leaving home!</p>

        <div class="uk-flex uk-align-center uk-flex-column">
            <a href="{{ config('app.url') }}">
                @component('emails.ui.button', ['type' => 'primary'])
                    Make an order
                @endcomponent
            </a>

            <div>
                <a href="{{ config('app.url_git') }}" target="_blanc" class="uk-icon-button" uk-icon="github"></a>
            </div>
        </div>
    @endcomponent
</div>

</body>
</html>
