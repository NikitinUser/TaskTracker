@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4 card">
        <div class="card-header login_nav">Вход</div>
        <form method="POST" class="card-body" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="login nickname_nav">Логин</label>

                <input id="login" type="text" class="form-control " name="login" value="{{ old('login') ??  old('login')}}" required autocomplete="login" autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="password_nav">Пароль</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn btn-primary login_nav">Вход</button>
            </div>
        </form>
    </div>
</div>
@endsection
