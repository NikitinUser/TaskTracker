@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 card">
        <div class="card-header registration_nav">Регистрация</div>
        <form method="POST" class="card-body" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="nickname_nav">Логин</label>

                <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

                @error('name')
                    <div class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="password_nav">Пароль</label>

                <input id="password" type="password" class="form-control" name="password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="repeat_password_nav">Повторите пароль</label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div>
                <button type="submit" class="btn btn-primary registration_nav">
                    Зарегистрироваться
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
