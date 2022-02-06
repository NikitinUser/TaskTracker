@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-center">
                <div class="card">
                    <form action="addRole" method="POST" class="row">
                        @csrf
                        
                        <div class="col-md-12 mb-3">
                            <lable>Название роли: </lable>
                            <input type="text" name="role_name" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="submit" value="Добавить" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection