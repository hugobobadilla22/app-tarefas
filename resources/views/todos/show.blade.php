@extends('layouts.app')

@section('title', 'Visualizar ToDo')

@section('content')
    <h1>{{ $todo->title }}</h1>
    <p>{{ $todo->content }}</p>
    <a href="{{ route('todos.index') }}" class="btn-btn-secondary">Voltar</a>
    <a href="{{ route('todos.edit', $todo) }}" class="btn btn-warning">Editar</a>
@endsection