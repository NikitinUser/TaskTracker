@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4 card">
        <div class="card-header">Регистрация</div>
        <form method="POST" class="card-body" action="{{ route('register') }}">
            @csrf

            <div class="form-group row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-right">Логин</label>

                <div class="col-md-6">
                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Повторите пароль</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Зарегистрироваться
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
