<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Todo App - @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <div class="navbar-nav">
                    @auth
                        <a href="{{ route('todos.index') }}" class="nav-link">Minhas Tarefas</a>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-link">Cadastra-se</a>
                    @endauth
                </div>
            </nav>
            @auth
                <p>Bem-vindo {{ Auth::user()->name }}</p>
            @endauth
            @if (session('success') || session('status'))
                <div id="success-message" class="alert alert-success">
                    {{ session('success') ?? session('status') }}
                </div>
            @endif
            @yield('content')
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const successMessage = document.getElementById('success-message');

                if (successMessage) {
                    setTimeout(function () {
                        successMessage.style.display = 'none';
                    }, 10000);
                }
            });
        </script>
    </body>
</html>
