@extends('layouts.after_default_us')


@section('content')

<div class="container_main dop_margin">
    <p class="mulishb fs-4 my_vacancy_h p-2 p-xl-1 p-xxl-0">Отклики и приглашения</p>
    <!-- Ваше представление vacancy_list.blade.php -->

    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="table_vacancy_thead">Статус</th>
                <th scope="col" class="table_vacancy_thead">Вакансия</th>
                <th scope="col" class="table_vacancy_thead">Дата</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userResponses as $response)
            <tr>
                <td class="table_vacancy_tbody">
                    <span class="status_text {{ $response->status === 'Принят' ? 'status_text_success' : ($response->status === 'Отклонен' ? 'status_text_danger' : '') }}">
                        @if ($response->status == 'Принят')
                            Приглашение
                        @elseif ($response->status == 'Отклонен')
                            Отказ
                        @else
                            На рассмотрении
                        @endif
                    </span>
                </td>
                <td class="table_vacancy_tbody">
                    <a class="table_vacancy_tbody tdnnn" href="{{ route('show', ['id' => $response->job->id]) }}">{{ $response->job->title }}</a>
                    <span class="color_thead">• <a class="color_thead tdnnn" href="{{ route('emp.profile', ['companyId' => $response->job->company->id]) }}">{{ $response->job->company->name }}</a></span>
                    
                </td>

                <td class="table_vacancy_tbody">{{ \Carbon\Carbon::parse($response->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    
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