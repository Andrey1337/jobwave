@extends('layouts.main_beforeEMP')


@section('content')

<p class="register_employer_text_h">Регистрация для поиска сотрудников</p>
<!-- Форма регистрации пользователя -->
<form class="form_register" method="post" action="{{route('register_employer')}}" enctype="multipart/form-data">
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
        <label for="email" class="form-label">Email</label>
        <input type="email" value="{{ old('email') }}" class="form-control form-control-for-company" required id="email" name="email" autofocus>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Название компании</label>
        <input class="form-control form-control-for-company" type="text" id="name" name="name" value="{{ old('name') }}" aria-describedby="emailHelp" required >
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Описание компании</label>
        <textarea class="form-control form-control-for-company" value="{{ old('description') }}" id="description" name="description" rows="3"></textarea>
    </div>
    
    <div class="mb-3">
        <label for="industry" class="form-label">Отрасль компании</label>
        <input class="form-control form-control-for-company" type="text" id="industry" name="industry" value="{{ old('industry') }}" aria-describedby="emailHelp" required>
    </div>

    <div class="select_size_company mb-3">
    <label for="company_size" class="form-label">Размер компании</label>
        <select class="form-select" id="company_size" name="company_size" aria-label="Default select example">
                <option value="маленькая">Маленькая</option>
                <option value="средняя">Средняя</option>
                <option value="большая">Большая</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="city" class="form-label">Город</label>
        <input class="form-control form-control-for-company" type="text" id="city" name="city" value="{{ old('city') }}" aria-describedby="emailHelp" required>
    </div>
    

    <div class="select_size_company mb-3">
    <label for="company_type" class="form-label">Тип компании</label>
        <select class="form-select" id="company_type" name="company_type" required aria-label="Default select example">
                <option value="Организация">Организация</option>
                <option value="Проект">Проект</option>
                <option value="Частное лицо">Частное лицо</option>
                <option value="Самозанятый">Самозанятый</option>
                <option value="Частный рекрутер">Частный рекрутер</option>
                <option value="Кадровое агентство">Кадровое агентство</option>
        </select>
    </div>


     <div class="input-group form_logo_comp mb-3">
        <input type="file" class="form-control form-control-for-company" id="logo" name="logo">
    </div>  

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control form-control-for-company" name="password" id="password" required  aria-describedby="passHelp">
        <div id="passHelp" class="form-text">Пароль должен быть не менее 8 символов.</div>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Повторите пароль</label>
        <input type="password" class="form-control form-control-for-company" name="password_confirmation" required id="password_confirmation">
    </div>
  <button type="submit" class="btn_bigger_main mt-4">Зарегистрироваться</button>
</form>

</div>

@endsection