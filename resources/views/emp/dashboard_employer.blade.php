@extends('layouts.main_afterEMP')


@section('content')

<div class="container_main">
    <div class="dashboard_emp_greetings_area">
        <div class="dashboard_emp_greetings_blocks">
            <div class="dashboard_emp_greetings_block align-items-sm-start text-center text-sm-start ">
                <p class="dashboard_emp_greetings_block_h mulishsb">Приступим к заполнению вакансий?</p>
                <p class="dashboard_emp_greetings_block_p mulishr">Готовы укрепить вашу команду новыми талантами? Первая вакансия - это ключ к успешному поиску персонала, который привнесет свежие идеи, энергию и профессионализм в ваш бизнес!</p>
                <p class="dashboard_emp_greetings_block_p mulishr">Доверьте нам свои вакансии, и мы поможем вам найти идеальных кандидатов, которые подойдут под требования вашей компании. Мы предоставим вам доступ к огромному пулу талантливых специалистов, готовых внести вклад в ваш успех.</p>
                <a href="{{route('create_vacancy')}}" class="btn_stock_main">Заполнить вакансию</a>
            </div>
            <div class="dashboard_emp_greetings_block_img">
                <img src="img/dash_emp/dash_greeting.svg" alt="greeting" class="dashboard_emp_greetings_img">
            </div>
        </div>

        <hr class="hr_blue_center">
        <p class="dashboard_emp_contacts_h_main mulishb">Связь с нами</p>

        <div class="connect_us_block">
        
            <div class="dashboard_emp_contacts_blocks">
    
                <div class="dashboard_emp_contacts_block">
                    <p class="dashboard_emp_contacts_block_h">Москва</p>
                    <p class="dashboard_emp_contacts_block_p">+7 495 555-55-55</p>
                </div>
                <div class="dashboard_emp_contacts_block">
                    <p class="dashboard_emp_contacts_block_h">Регионы</p>
                    <p class="dashboard_emp_contacts_block_p">+7 495 555-55-00</p>
                </div>
    
            </div>
            
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Редактировать данные компании</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="form_register" method="post" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
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
                                    <input type="email" value="{{ old('email', auth()->guard('company')->user()->email) }}" class="form-control form-control-for-company" required id="email" name="email" autofocus>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="name" class="form-label">Название компании</label>
                                    <input class="form-control form-control-for-company" type="text" id="name" name="name" value="{{ old('name', auth()->guard('company')->user()->name) }}" aria-describedby="emailHelp" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="description" class="form-label">Описание компании</label>
                                    <textarea class="form-control form-control-for-company" id="description" name="description" rows="3">{{ old('description', auth()->guard('company')->user()->description) }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="industry" class="form-label">Отрасль компании</label>
                                    <input class="form-control form-control-for-company" type="text" id="industry" name="industry" value="{{ old('industry', auth()->guard('company')->user()->industry) }}" aria-describedby="emailHelp" required>
                                </div>
                            
                                <div class="select_size_company mb-3">
                                    <label for="company_size" class="form-label">Размер компании</label>
                                    <select class="form-select" id="company_size" name="company_size" aria-label="Default select example">
                                        <option value="маленькая" {{ old('company_size', auth()->guard('company')->user()->company_size) == 'маленькая' ? 'selected' : '' }}>Маленькая</option>
                                        <option value="средняя" {{ old('company_size', auth()->guard('company')->user()->company_size) == 'средняя' ? 'selected' : '' }}>Средняя</option>
                                        <option value="большая" {{ old('company_size', auth()->guard('company')->user()->company_size) == 'большая' ? 'selected' : '' }}>Большая</option>
                                    </select>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="city" class="form-label">Город</label>
                                    <input class="form-control form-control-for-company" type="text" id="city" name="city" value="{{ old('city', auth()->guard('company')->user()->city) }}" aria-describedby="emailHelp" required>
                                </div>
                                
                                <div class="select_size_company mb-3">
                                    <label for="company_type" class="form-label">Тип компании</label>
                                    <select class="form-select" id="company_type" name="company_type" required aria-label="Default select example">
                                        <option value="Организация" {{ old('company_type', auth()->guard('company')->user()->company_type) == 'Организация' ? 'selected' : '' }}>Организация</option>
                                        <option value="Проект" {{ old('company_type', auth()->guard('company')->user()->company_type) == 'Проект' ? 'selected' : '' }}>Проект</option>
                                        <option value="Частное лицо" {{ old('company_type', auth()->guard('company')->user()->company_type) == 'Частное лицо' ? 'selected' : '' }}>Частное лицо</option>
                                        <option value="Самозанятый" {{ old('company_type', auth()->guard('company')->user()->company_type) == 'Самозанятый' ? 'selected' : '' }}>Самозанятый</option>
                                        <option value="Частный рекрутер" {{ old('company_type', auth()->guard('company')->user()->company_type) == 'Частный рекрутер' ? 'selected' : '' }}>Частный рекрутер</option>
                                        <option value="Кадровое агентство" {{ old('company_type', auth()->guard('company')->user()->company_type) == 'Кадровое агентство' ? 'selected' : '' }}>Кадровое агентство</option>
                                    </select>
                                </div>
                            
                            
                                <div class="input-group form_logo_comp mb-3">
                                    <input type="file" class="form-control form-control-for-company" id="logo" name="logo">
                                </div>  
                            
                                
                                
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn_stock_outline mulishr" data-bs-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn_stock_outline mulishr">Сохранить изменения</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Изменить пароль компании</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('company.change.password') }}">
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
                                    <label for="password" class="form-label">Новый пароль</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Подтвердите новый пароль</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn_stock_outline mulishr" data-bs-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn_stock_outline mulishr">Сохранить изменения</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="update_info_company">
               
            </div>
        </div>
        

        <div class="dashboard_emp_contacts_blocks">
            @if (session('success'))
            <div class="succ" id="successAlert">
                <div class="alert_default">
                    {{ session('success') }}
                </div>
            </div>
            @endif
            @if ($company->subscription_level === 'Бесплатный')
                <div class="subscription-block">
                    <p>Ваш текущий уровень подписки: <strong>Бесплатный</strong></p>
                    <p>Ограничение: Максимальное количество вакансий - 5</p>
                        <button type="button" class="m-2 m-xl-2 m-xxl-0 btn_outline_14 align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Изменить подписку
                        </button>
                </div>
            @else
                <div class="subscription-block">
                    <p>Ваш текущий уровень подписки: <strong>Расширенный</strong></p>
                    <form action="{{ route('cancel.subscription') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Отменить подписку</button>
                    </form>
                </div>
            @endif

        </div>

         <!-- Modal -->
         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Оформление подписки</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-register" action="{{ route('payment.process') }}" method="POST">
                            @csrf
                            <label for="card_number">Номер карты:</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" maxlength="19" required><br>
                            <label for="expiry_date">Срок действия (MM/YY):</label>
                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" maxlength="5" required><br>
                            <label for="cvv">CVV код:</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" required>
                            <p class="mulishr mt-3">Цена подписки составляет: 999 рублей в месяц</p>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn_stock_outline mulishr" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn_stock_outline mulishr">Оплатить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


</div>



<script>
    // Функция для форматирования номера карты
    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        input.value = value;
    }

    // Функция для форматирования срока действия карты
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        input.value = value;
    }

    // Функция для валидации номера карты
    function validateCardNumber(input) {
        let cardNumber = input.value.replace(/\s/g, '');
        if (!/^\d{16}$/.test(cardNumber)) {
            alert('Пожалуйста, введите корректный номер карты (16 цифр)');
            input.value = '';
            input.focus();
            return false;
        }
        return true;
    }

    // Функция для валидации срока действия карты
    function validateExpiryDate(input) {
        let expiryDate = input.value;
        if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
            alert('Пожалуйста, введите корректный срок действия карты (MM/YY)');
            input.value = '';
            input.focus();
            return false;
        }
        return true;
    }

    // Функция для валидации CVV кода
    function validateCVV(input) {
        let cvv = input.value;
        if (!/^\d{3}$/.test(cvv)) {
            alert('Пожалуйста, введите корректный CVV код (3 цифры)');
            input.value = '';
            input.focus();
            return false;
        }
        return true;
    }

    // Обработчик события ввода номера карты
    document.getElementById('card_number').addEventListener('input', function(event) {
        formatCardNumber(event.target);
    });

    // Обработчик события ввода срока действия карты
    document.getElementById('expiry_date').addEventListener('input', function(event) {
        formatExpiryDate(event.target);
    });

   // Функция для проверки срока действия карты
   function validateExpiryDate(input) {
        let currentDate = new Date();
        let inputDate = new Date();
        let [month, year] = input.value.split('/');

        // Добавляем 1 к месяцу, так как месяцы в JavaScript начинаются с 0
        inputDate.setFullYear('20' + year, month - 1, 1);

        if (inputDate < currentDate) {
            alert('Срок действия карты истек');
            input.value = '';
            input.focus();
            return false;
        }
        return true;
    }

    // Обработчик отправки формы
    document.querySelector('.form-register').addEventListener('submit', function(event) {
        let cardNumberInput = document.getElementById('card_number');
        let expiryDateInput = document.getElementById('expiry_date');
        let cvvInput = document.getElementById('cvv');

        if (!validateCardNumber(cardNumberInput) ||
            !validateExpiryDate(expiryDateInput) ||
            !validateCVV(cvvInput)) {
            event.preventDefault(); // Отмена отправки формы при наличии некорректных данных
        }
    });
</script>
@endsection