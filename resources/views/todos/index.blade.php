@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')
    <h1>Minhas Tarefas</h1>
    @auth
        <div class="mb-3">
            <form method="GET" action="{{ route('todos.index') }}">
                <label for="date" class="form-label">Selecionar Data:</label>
                <input type="date" id="date" name="date" value="{{ $date }}" class="form-control d-inline-block w-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('todos.index') }}" class="btn btn-secondary">Hoje</a>
            </form>
        </div>
        <a href="{{ route('todos.create') }}" class="btn btn-primary mb-3">Criar Nova Tarefa</a>
        @if ($todos->isEmpty())
            <p>Nenhuma Tarefa encontrada.</p>
        @else 
            @if (Carbon\Carbon::parse($date)->isToday())
                <h2>Tarefas de Hoje</h2>
            @else
                <h2>Tarefas de {{ Carbon\Carbon::parse($date ?? Carbon\Carbon::today()->toDateString())->format('d/m/Y') }}</h2>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Açoes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $todo)
                        <tr>
                            <td>{{ $todo->id }}</td>
                            <td>
                                @if ($todo->done)
                                    <s>{{ $todo->title }}</s>
                                @else
                                    {{ $todo->title }}
                                @endif
                                <div>
                                    <b>Data: {{ $todo->date }}</b> - <b>Hora: {{ $todo->time }}</b>
                                </div>
                            </td>
                            <td>
                                <form style="display:inline-block" action="{{ route('todos.toggle-done', $todo->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        {{ $todo->done ? 'Marcar como não completo' : 'Marcar como completo' }}
                                    </button>
                                </form>
                                <a href="{{ route('todos.edit', $todo) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <p>Faça <a href="{{ route('login') }}">Login</a> ou <a href="{{ route('register') }}">Cadastre-se para criar e ver suas tarefas diarias</a></p>
    @endauth
@endsection