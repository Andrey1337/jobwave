@extends ('layouts.default_for_users')
@section ('content')
<p class="register_employer_text_h">Регистрация для соискателей</p>
<div class="container_main">
<form class="form_register2" method="post" action="{{ route('applicant.register.submit') }}" enctype="multipart/form-data">
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
        <label for="first_name" class="form-label">Имя</label>
        <input type="text" value="{{ old('first_name') }}" class="form-control form-control-for-candidate"  id="first_name" name="first_name" autofocus>
    </div>

    <div class="mb-3">
        <label for="last_name" class="form-label">Фамилия</label>
        <input class="form-control form-control-for-candidate" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" >
    </div>

    <div class="select_size_candidate mb-3">
        <label for="gender" class="form-label">Пол</label>
        <select class="form-select" id="gender" name="gender"  aria-label="Default select example">
            <option value="Мужчина">Мужчина</option>
            <option value="Женщина">Женщина</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="birth_date" class="form-label">Дата рождения</label>
        <input class="form-control form-control-for-candidate" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" >
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Телефон</label>
        <input class="form-control form-control-for-candidate" type="tel" id="phone" name="phone" value="{{ old('phone') }}" >
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" value="{{ old('email') }}" class="form-control form-control-for-candidate"  id="email" name="email">
    </div>
    
    <div class="mb-3">
        <label for="region_id" class="form-label">Регион</label>
        <select class="form-select" id="region_id" name="region_id">
            <option value="">Выберите регион</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" @if(old('region_id') == $region->id) selected @endif>{{ $region->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="select_size_candidate mb-3">
        <label for="status" class="form-label">Статус поиска работы</label>
        <select class="form-select" id="status" name="status"  aria-label="Default select example">
            <option value="Активно ищу работу">Активно ищу работу</option>
            <option value="Рассматриваю предложения">Рассматриваю предложения</option>
            <option value="Не ищу работу">Не ищу работу</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control form-control-for-candidate" name="password" id="password" >
        <div id="passHelp" class="form-text">Пароль должен быть не менее 8 символов.</div>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Повторите пароль</label>
        <input type="password" class="form-control form-control-for-candidate" name="password_confirmation"  id="password_confirmation">
    </div>

    <button type="submit" class="btn_bigger_main mt-4">Зарегистрироваться</button>
</form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');

    phoneInput.addEventListener('input', function() {
        let value = phoneInput.value.replace(/\D/g, ''); // Удаляем все нецифровые символы
        let formattedValue = '';
        
        if (value.length > 0) {
            if (value.length <= 1) {
                formattedValue = '+' + value;
            } else if (value.length <= 4) {
                formattedValue = '+' + value.slice(0, 1) + ' (' + value.slice(1);
            } else if (value.length <= 7) {
                formattedValue = '+' + value.slice(0, 1) + ' (' + value.slice(1, 4) + ') ' + value.slice(4);
            } else if (value.length <= 9) {
                formattedValue = '+' + value.slice(0, 1) + ' (' + value.slice(1, 4) + ') ' + value.slice(4, 7) + '-' + value.slice(7);
            } else {
                formattedValue = '+' + value.slice(0, 1) + ' (' + value.slice(1, 4) + ') ' + value.slice(4, 7) + '-' + value.slice(7, 9) + '-' + value.slice(9, 11);
            }
        }

        phoneInput.value = formattedValue;
    });
});
</script>
@endsection
