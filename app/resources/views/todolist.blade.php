<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Picturework Todo List Application</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

<!-- React root DOM -->
<div class="container">
    <div id="container" class="col-md-8 col-md-offset-2">  </div>
</div>

<!-- React JS -->
<script src="https://npmcdn.com/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
