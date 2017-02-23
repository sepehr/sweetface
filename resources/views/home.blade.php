<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SweetFace</title>

    <link href="/css/app.css" rel="stylesheet">
    <link rel="icon" href="/favicon.png" type="image/x-icon">
</head>
<body>
    <div id="app">
        <sweetface
                :user="{{ $user or 'false' }}"
                logout="{{ route('home') }}"
                redirect="{{ route('home') }}"
                message="{{ session('message') }}">
        </sweetface>
    </div>
    <script src="/js/app.js" type="application/javascript"></script>
</body>
</html>
