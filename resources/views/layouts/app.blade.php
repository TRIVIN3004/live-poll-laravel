<!DOCTYPE html>
<html>
<head>
    <title>Live Poll Platform</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background-color: #f5f7fa;
        }
        .poll-card:hover {
            transform: scale(1.02);
            transition: 0.2s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">🗳 Live Poll System</span>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>
