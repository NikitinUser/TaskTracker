@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4 card">
        <div class="card-header">Вход</div>
        <form method="POST" class="card-body" action="{{ route('login') }}">
            @csrf

            <div class="form-group row mb-3">
                <label for="login" class="col-md-4 col-form-label text-md-right">Логин</label>

                <div class="col-md-6">
                    <input id="login" type="text" class="form-control " name="login" value="{{ old('login') ??  old('login')}}" required autocomplete="login" autofocus>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Войти
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
