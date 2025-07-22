@extends('layouts.app')

@section('title', 'Novo Tarefas')

@section('content')
    <h1>Criar Nova Tarefas</h1>
    <form action="{{ route('todos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control mb-3" value="{{ old('title') }}">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <label for="date" class="form-label">Data</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}">
            @error('date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <label for="time" class="form-label">Data</label>
            <input type="time" name="time" id="time" class="form-control" value="{{ old('time') }}">
            @error('time')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@endsection