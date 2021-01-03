<!DOCTYPE HTML>
<html>
<head>
    <title>User Card - {{ $usercomments->name }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/noscript.css') }}" rel="stylesheet">
</head>
<body class="is-preload">
<div id="wrapper">
    <section id="main">
        <header>
            <span class="avatar"><img src="{{ asset("images/users/1.jpg") }}" /></span>
            <h1>{{ $usercomments->name }}</h1>
            <p>{{ nl2br($usercomments->comments) }}</p>
        </header>
    </section>
    <footer id="footer">
        <ul class="copyright">
            <li>&copy; Pictureworks</li>
        </ul>
    </footer>

</div>
</body>
</html>
