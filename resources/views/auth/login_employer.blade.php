@extends('layouts.main_beforeEMP')


@section('content')

<div class="container_main">
    <p class="auth_employer_text_h">Поиск сотрудников</p>

    <form class="form_auth" method="post" action="{{route('login_employer')}}">
    @csrf

    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" value="{{ old('email') }}" class="form-control form-control-for-company" required id="email" name="email" autofocus>
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input type="password" class="form-control form-control-for-company" name="password" id="password" required  aria-describedby="passHelp">
        </div>

    
    <button type="submit" class="btn_bigger_main mt-4">Войти</button>
    </form>

</div>


@endsection