@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h1>Login com seu Usúario</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Lembrar-me</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link">Esqueceu sua senha?</a>
                        @endif
                        <button class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection