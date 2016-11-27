<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!Auth::guest())
        <meta name="api-token" content="{{ Auth::user()->api_token }}">
    @endif
    <title>{{ $page_title or 'Dashboard' }} - {{ config('app.name', 'Safebox') }}</title>
    <link href="/css/app.css" rel="stylesheet">
</head>