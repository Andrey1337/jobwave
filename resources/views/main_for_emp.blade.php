@extends('layouts.main_beforeEMP')


@section('content')

<section class="greeting_area">
    <div class="container_main">
        <div class="greeting_block">
            <p class="greet_h mulishB fs-sm-1">Разместите свою вакансию на <span class="k2db">JobWave</span></p>
            <p class="greet_p mulish16r">Находите сотрудников среди тех, кто хочет работать у вас. JobWave - сервис топ-50 по поиску сотрудников в РФ</p>
            <a href="{{route('search_main')}}" class="btn_bigger_main">Разместить вакансию</a>
        </div>
    </div>
</section>

<section class="search_for_emp_area">
    <div class="container_main">
        <div class="search_for_emp_block search_for_emp">
        <p class="search_for_emp_h mulishB">Какие сотрудники есть на <span class="k2db">JobWave</span>?</p>
            <p class="search_for_emp_p mulish16r">Не ждите откликов - найдите нужного вам сотрудника сами среди множества резюме</p>

            <form action="{{ route('search_main') }}" method="POST" class="d-flex search_for_emp_function form_searches" role="search">
                @csrf
                <input type="hidden" name="search_query" id="search_query_hidden">
                <input class="form-control search_inp" type="search" id="search_input" placeholder="Водитель-курьер" aria-label="Search">
                <button class="btn_bigger" type="submit">Найти сотрудника</button>
                <button class="btn_search" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <div class="often_search_block">
                <p class="often_search_p mulish16r">Часто ищут резюме:</p>
                <button class="pink_bg fz12 mulishr fff">Грузчик</button>
                <button class="green_bg fz12 mulishr fff">Начальник</button>
                <button class="brown_bg fz12 mulishr fff">Продавец-консультант</button>
            </div>

        </div>
    </div>
</section>

<section class="where_to_begin_area">
    <div class="container_main">
        <p class="where_to_begin_h mulishb">С чего начать поиск сотрудников?</p>

        <div class="where_to_begin_blocks flex-column align-items-center align-items-lg-normal flex-lg-row">
            <div class="where_to_begin_block">
                <img src="img/icons/where_to_begin_1.svg" alt="number" class="where_to_begin_number_img">
                <div class="where_to_begin_block_inner">
                    <p class="where_to_begin_block_h mulishb fs-4">Зарегистрируйтесь</p>
                    <p class="where_to_begin_block_p mulishr">И получите доступ к размещению вакансий на JobWave</p>
                </div>
            </div>

            <div class="where_to_begin_block">
                <img src="img/icons/where_to_begin_2.svg" alt="number" class="where_to_begin_number_img">
                <div class="where_to_begin_block_inner">
                    <p class="where_to_begin_block_h mulishb fs-4">Разместите вакансию</p>
                    <p class="where_to_begin_block_p mulishr">Получайте отклики с контактами соискателей</p>
                </div>
            </div>

            <div class="where_to_begin_block">
                <img src="img/icons/where_to_begin_3.svg" alt="number" class="where_to_begin_number_img">
                <div class="where_to_begin_block_inner">
                    <p class="where_to_begin_block_h mulishb fs-4">Выбирайте лучших</p>
                    <p class="where_to_begin_block_p mulishr">Из тех, кто уже хочет у вас работать</p>
                </div>  
            </div>
        </div>

        <a href="{{route('search_main')}}" class=" btn_under_where_to_begin">Начать подбор на JobWave</a>

    </div>
</section>

<section class="vacancy_on_jobwave_area">
    <div class="container_main">
        <div class="vacancy_on_jobwave_main_block flex-column flex-lg-row">
            <div class="vacancy_on_jobwave_text_block flex-wrap align-content-center flex-lg-nowrap align-content-lg-normal">
                <p class="vacancy_on_jobwave_h mulishb">Почему стоит разместить вакансию на <span class="k2db">JobWave</span>?</p>
                <p class="vacancy_on_jobwave_p mulishr">Вакансия - это предложение о работе, включающее в себя описание должности, требования к соискателю и предлагаемые условия труда.</p>
                <a href="{{route('search_main')}}" class="btn_bigger_main btn_bigger_main_vacancy ">Разместить вакансию от 999 ₽</a>
            </div>
    
            <div class="vacancy_on_jobwave_images_blocks flex-wrap align-content-center flex-lg-nowrap align-content-lg-normal">
                <div class="vacancy_on_jobwave_image_block">
                    <img src="img/icons/vacancy_on_jobwave_1_img.svg" alt="" class="vacancy_on_jobwave_img">

                        <div class="vacancy_on_jobwave_image_inner_block">
                            <p class="vacancy_on_jobwave_image_h mulishb">Широкий охват аудитории</p>
                            <p class="vacancy_on_jobwave_image_p mulishr">Более 80% активных профессионалов регулярно посещают JobWave.</p>
                        </div>
                </div>
    
                <div class="vacancy_on_jobwave_image_block">
                    <img src="img/icons/vacancy_on_jobwave_2_img.svg" alt="" class="vacancy_on_jobwave_img">
                        <div class="vacancy_on_jobwave_image_inner_block">
                            <p class="vacancy_on_jobwave_image_h mulishb">Эффективный поиск</p>
                            <p class="vacancy_on_jobwave_image_p mulishr">Около 69% работодателей находят сотрудников в первые недели размещения вакансии.</p>
                        </div>    
                </div>
    
                <div class="vacancy_on_jobwave_image_block">
                    <img src="img/icons/vacancy_on_jobwave_3_img.svg" alt="" class="vacancy_on_jobwave_img">
                        <div class="vacancy_on_jobwave_image_inner_block">
                            <p class="vacancy_on_jobwave_image_h mulishb">Технологии</p>
                            <p class="vacancy_on_jobwave_image_p mulishr">Используем передовые технологии и улучшаем процесс подбора, радуя 90% клиентов.</p>
                        </div>
                </div>
    
            </div>
        </div>
        
    </div>
</section>

<section class="contact_support_jobwave_area">
    <div class="container_main">
        <div class="contact_support_jobwave_blocks">

            <div class="contact_support_jobwave_top_text_block">
                <p class="contact_support_jobwave_top_text_h mulishb">Помощь и поддержка</p>
                <p class="contact_support_jobwave_top_text_p mulishr">Техническая поддержка, помощь в выборе и расчёте пакета услуг по телефону</p>
            </div>

            <div class="contact_support_jobwave_bot_text_inner_blocks d-flex flex-column flex-lg-row justify-content-center">

                <div class="contact_support_jobwave_bot_text_block d-flex flex-column align-items-center align-items-lg-start">
                    <p class="contact_support_jobwave_bot_text_block_phone fs-4 mulishb">+7-985-482-82-48</p>
                    <p class="contact_support_jobwave_bot_text_block_p fs-5 mulishm">Москва и МО</p>
                </div>
                <div class="contact_support_jobwave_bot_text_block d-flex flex-column align-items-center align-items-lg-center">
                    <p class="contact_support_jobwave_bot_text_block_phone fs-4 mulishb">+7-999-918-67-58</p>
                    <p class="contact_support_jobwave_bot_text_block_p fs-5 mulishm">Санкт-Петербург и ЛО</p>
                </div>
                <div class="contact_support_jobwave_bot_text_block d-flex flex-column align-items-center align-items-lg-end">
                    <p class="contact_support_jobwave_bot_text_block_phone fs-4 mulishb">8-800-555-35-35</p>
                    <p class="contact_support_jobwave_bot_text_block_p fs-5 mulishm">Регионы РФ</p>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search_input'); // Получаем поле ввода поиска
        const hiddenInput = document.getElementById('search_query_hidden'); // Получаем скрытое поле для хранения значения поиска

        // Функция для установки значения скрытого поля и отправки формы
        function setSearchAndSubmit(value) {
            searchInput.value = value; // Устанавливаем значение поля ввода
            hiddenInput.value = value; // Устанавливаем значение скрытого поля
            document.querySelector('.form_searches').submit(); // Отправляем форму
        }

        // Назначаем обработчики событий для кнопок с частыми поисками
        document.querySelectorAll('.often_search_block button').forEach(button => {
            button.addEventListener('click', function() {
                const value = this.textContent.trim(); // Получаем текст кнопки и удаляем лишние пробелы
                setSearchAndSubmit(value); // Устанавливаем значение поля ввода и отправляем форму
            });
        });

        // Назначаем обработчик отправки формы для установки значения скрытого поля
        document.querySelector('.form_searches').addEventListener('submit', function() {
            hiddenInput.value = searchInput.value; // Устанавливаем значение скрытого поля равным значению поля ввода
        });
    });
</script>
@endsection

