@extends('layouts.app')

@section('title', 'Editar ToDo')

@section('content')
    <h1>Editar Todo</h1>
    <form action="{{ route('todos.update', $todo) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $todo->title) }}">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="done" class="form-label">Completo?</label>
            <input type="checkbox" name="done" id="done" value="1" {{ old('done', $todo->done) ? 'checked' : '' }}>
            @error('done')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <form action="{{ route('todos.toggle-done', $todo->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-secondary">
            {{ $todo->done ? 'Marcar como não completo' : 'Marcar como completo' }}
        </button>
    </form>
@endsection