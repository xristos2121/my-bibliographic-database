<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Research Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    @vite(['resources/js/front.js'])

</head>
<body>
<div class="header">
    <h1>Academic Research Portal</h1>
    <div class="menu">
        <a href="{{ url('/') }}">Simple Search</a>
        <a href="{{ url('/advanced-search') }}">Advanced Search</a>
        <a href="{{ url('/browse') }}">Browse</a>
    </div>
</div>

{{ $slot }}

</body>
</html>
