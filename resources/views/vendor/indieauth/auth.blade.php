<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
    body,
    html {
        height: 100%;
    }

    body {
        background: #f1f4f8;
        margin: 0;
        padding: 0;
    }

    body,
    button,
    input,
    select,
    textarea {
        color: #363636;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 1rem;
        line-height: 1.67;
    }

    .container {
        display: flex;
        height: 100%;
    }

    .container > form {
        width: 90%;
        max-width: 700px;
        margin: auto;
    }

    .client-icon {
        position: relative;
        top: 0.125rem;
    }

    button[type="submit"] {
        -moz-appearance: none;
        -webkit-appearance: none;
        background-color: #48c78e;
        border: none;
        border-radius: 0.25rem;
        color: #fff;
        padding: 0.25rem 0.5rem 0.375rem;
    }
    </style>
</head>
<body>
    <div class="container">
        <form action="{{ url('/indieauth') }}" method="post">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $client_description = e(session('client_id')); // This is a URL.

                if (! empty($client['name'])) {
                    $client_description = e($client['name']); // The name we previously "discovered."
                }

                if (! empty($client['icon'])) { // A locally cached "logo."
                    $client_description = '<img class="client-icon" src="' . $client['icon'] . '" height="16" alt=""> <strong>' . $client_description . '</strong>';
                }
            @endphp

            <p>{!! __('You are attempting to log in to :client_description.', ['client_description' => $client_description]) !!}</p>

            @if (! empty($scopes))
                <p>{{ __('Additionally, :client_name is requesting the following scopes:', ['client_name' => trim(strip_tags($client_description)) ]) }}</p>

                <fieldset>
                    <legend>{{ __('Scopes') }}</legend>

                    @foreach ($scopes as $scope)
                        <div class="form-group">
                            <label><input type="checkbox" name="scope[]" value="{{ $scope }}" checked> {{ ucfirst($scope) }}</label>
                        </div>
                    @endforeach
                </fieldset>

                <p>{{ __('Only authorize third-party applications you trust.') }}</p>
            @endif

            <p><button type="submit">{{ empty($scopes) ? __('Log In') : __('Authorize') }}</button></p>
        </form>
    </div>
</body>
</html>
