@extends('layouts.main_afterEMP')


@section('content')

<div class="container_main dop_margin">
    <p class="mulishb fs-4 my_vacancy_h p-2 p-xl-1 p-xxl-0">Мои вакансии</p>
    <!-- Ваше представление vacancy_list.blade.php -->
    @if (session('success'))
        <div class=" succ" id="liveAlertPlaceholder" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="alert_default" >
                {{ session('success') }}
            </div>
        </div>
    @endif
 
    <script>
    // Ждем загрузки всего документа
    $(document).ready(function() {
        // Показываем уведомление
        $('.succ').toast('show');
    });
    </script>
    <!-- Ваша текущая разметка для вывода списка вакансий -->


    <ul class="nav nav-pills tabs_vacancy_block mb-3 p-2 p-xl-1 p-xxl-0" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link mulishr link_vacancy_changer active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Все</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link mulishr link_vacancy_changer" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Активные</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link mulishr link_vacancy_changer" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">В архиве</button>
        </li>

        <a href="{{route('create_vacancy')}}" class="btn_stock_outline mulishb">Заполнить вакансию</a>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane table-responsive-md fade show active " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="table_vacancy_thead">Вакансия</th>
                            <th scope="col" class="table_vacancy_thead">Сохранена</th>
                            <th scope="col" class="table_vacancy_thead">Статус</th>
                            <th scope="col" class="table_vacancy_thead">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allVacancies as $vacancy)
                        <tr>
                            <form action="{{ route('delete.vacancy', $vacancy->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            <td class="table_vacancy_tbody">{{ $vacancy->title }} <span class="color_thead">({{ $vacancy->company->name }}, {{ $vacancy->company->city }})</span> 
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#777777" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                            </td>
                            </form>
                            <td class="table_vacancy_tbody">{{ \Carbon\Carbon::parse($vacancy->updated_at)->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                            <td class="table_vacancy_tbody"><span class="status_text {{ $vacancy->status === 'Активна' ? 'status_text_success' : 'status_text_danger' }}">{{ $vacancy->status }}</span></td>
                            <td class="table_vacancy_tbody checkbox_status_vacancy_style">
                                <form action="{{ route('change_vacancy_status', ['id' => $vacancy->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $vacancy->status === 'Активна' ? 'В архиве' : 'Активна' }}">
                                    <div class="form-check form-switch d-flex d-sm-block justify-content-center justify-content-md-start align-items-end align-items-md-start d-md-block">
                                        <input class="form-check-input vacancy-switch" type="checkbox" id="switch{{ $vacancy->id }}" @if($vacancy->status === 'Активна') checked @endif>
                                        <label class="form-check-label d-none d-sm-block" for="switch{{ $vacancy->id }}">{{ $vacancy->status === 'Активна' ? 'Перевести в архив' : 'Активировать' }}</label>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            <nav aria-label="Page navigation example" class="pagin_table_vacancy">
                <ul class="pagination justify-content-center">
                    {{-- Кнопка "Назад" --}}
                    <li class="page-item {{ $allVacancies->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $allVacancies->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    {{-- Страницы --}}
                    @for ($i = 1; $i <= $allVacancies->lastPage(); $i++)
                        <li class="page-item {{ $i == $allVacancies->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $allVacancies->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Кнопка "Вперед" --}}
                    <li class="page-item {{ $allVacancies->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $allVacancies->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    
        <div class="tab-pane table-responsive-md fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="table_vacancy_thead">Вакансия</th>
                        <th scope="col" class="table_vacancy_thead">Сохранена</th>
                        <th scope="col" class="table_vacancy_thead">Статус</th>
                        <th scope="col" class="table_vacancy_thead">Действия</th> <!-- Добавлено -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vacancies as $vacancy)
                    <tr>
                    <form action="{{ route('delete.vacancy', $vacancy->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            <td class="table_vacancy_tbody">{{ $vacancy->title }} <span class="color_thead">({{ $vacancy->company->name }}, {{ $vacancy->company->city }})</span> 
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#777777" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                            </td>
                            </form>
                        <td class="table_vacancy_tbody">{{ \Carbon\Carbon::parse($vacancy->updated_at)->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                        <td class="table_vacancy_tbody"><span class="status_text {{ $vacancy->status === 'Активна' ? 'status_text_success' : 'status_text_danger' }}">{{ $vacancy->status }}</span></td>
                        <td class="table_vacancy_tbody checkbox_status_vacancy_style">
                            <form action="{{ route('change_vacancy_status', ['id' => $vacancy->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Активна">
                                <div class="form-check form-switch d-flex d-sm-block justify-content-center justify-content-md-start align-items-end align-items-md-start d-md-block">
                                    <input class="form-check-input vacancy-switch" type="checkbox" id="switch{{ $vacancy->id }}" @if($vacancy->status === 'Активна') checked @endif>
                                    <label class="form-check-label ms-2 d-none d-sm-block" for="switch{{ $vacancy->id }}">Перевести в архив</label>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <nav aria-label="Page navigation example" class="pagin_table_vacancy">
                <ul class="pagination justify-content-center">
                    {{-- Кнопка "Назад" --}}
                    <li class="page-item {{ $vacancies->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $vacancies->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    {{-- Страницы --}}
                    @for ($i = 1; $i <= $vacancies->lastPage(); $i++)
                        <li class="page-item {{ $i == $vacancies->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $vacancies->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Кнопка "Вперед" --}}
                    <li class="page-item {{ $vacancies->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $vacancies->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        
        <div class="tab-pane table-responsive-md fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="table_vacancy_thead">Вакансия</th>
                        <th scope="col" class="table_vacancy_thead">Сохранена</th>
                        <th scope="col" class="table_vacancy_thead">Статус</th>
                        <th scope="col" class="table_vacancy_thead">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archivedVacancies as $vacancy)
                    <tr>
                    <form action="{{ route('delete.vacancy', $vacancy->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            <td class="table_vacancy_tbody">{{ $vacancy->title }} <span class="color_thead">({{ $vacancy->company->name }}, {{ $vacancy->company->city }})</span> 
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#777777" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                            </td>
                            </form>    
                        <td class="table_vacancy_tbody">{{ \Carbon\Carbon::parse($vacancy->updated_at)->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                        <td class="table_vacancy_tbody"><span class="status_text {{ $vacancy->status === 'Активна' ? 'status_text_success' : 'status_text_danger' }}"">{{ $vacancy->status }}</span></td>
                        <td class="table_vacancy_tbody checkbox_status_vacancy_style">
                            <form action="{{ route('change_vacancy_status', ['id' => $vacancy->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Активна">
                                <div class="form-check form-switch d-flex d-sm-block justify-content-center justify-content-md-start align-items-end align-items-md-start d-md-block">
                                    <input class="form-check-input vacancy-switch" type="checkbox" id="switch{{ $vacancy->id }}" @if($vacancy->status === 'Активна') checked @endif>
                                    <label class="form-check-label d-none d-sm-block" for="switch{{ $vacancy->id }}">Активировать</label>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <nav aria-label="Page navigation example" class="pagin_table_vacancy">
                <ul class="pagination justify-content-center">
                    {{-- Кнопка "Назад" --}}
                    <li class="page-item {{ $archivedVacancies->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $archivedVacancies->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    {{-- Страницы --}}
                    @for ($i = 1; $i <= $archivedVacancies->lastPage(); $i++)
                        <li class="page-item {{ $i == $archivedVacancies->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $archivedVacancies->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Кнопка "Вперед" --}}
                    <li class="page-item {{ $archivedVacancies->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $archivedVacancies->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    </div>












    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Находим все чекбоксы с классом .vacancy-switch
            const vacancySwitches = document.querySelectorAll('.vacancy-switch');
    
            // Добавляем обработчик события для каждого чекбокса
            vacancySwitches.forEach(function(switchCheckbox) {
                switchCheckbox.addEventListener('change', function() {
                    // Находим родительскую форму
                    const form = switchCheckbox.closest('form');
    
                    // Если чекбокс выключен (unchecked), то меняем значение скрытого поля status на "Активна"
                    if (!this.checked) {
                        form.querySelector('input[name="status"]').value = "Активна";
                    } else {
                        // Если чекбокс включен (checked), то меняем значение скрытого поля status на "Архив"
                        form.querySelector('input[name="status"]').value = "В архиве";
                    }
    
                    // Отправляем форму на сервер
                    form.submit();
                });
            });
        });
    </script>
    
    <script>
    // Функция для сохранения текущей вкладки в localStorage
    function saveActiveTab(tabId) {
        localStorage.setItem('activeTab', tabId);
    }

    // Функция для получения текущей вкладки из localStorage
    function getActiveTab() {
        return localStorage.getItem('activeTab');
    }

    // При загрузке страницы проверяем, есть ли сохраненная вкладка в localStorage и активируем ее
    document.addEventListener('DOMContentLoaded', function() {
        const activeTab = getActiveTab();
        if (activeTab) {
            const tabButton = document.querySelector(activeTab);
            if (tabButton) {
                tabButton.click();
            }
        }
    });

    // Обработчик события для сохранения текущей вкладки при ее активации
    const tabButtons = document.querySelectorAll('.link_vacancy_changer');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = '#' + this.getAttribute('id');
            saveActiveTab(tabId);
        });
    });
</script>




    <form method="post" class="d-none" action="{{route('logout_employer')}}">
        @csrf
        <button class="btn_bigger_main">Выйти</button>
    </form>

</div>



@endsection