@extends('layouts.navbar_beforeUSER')


@section('content')


<section class="search_for_user_area search_for_user_area_main "> 
        <div class="search_for_emp_block_second_main search_for_emp_block_second ">
            <p class="search_for_user_block_h">Ищите работу уже сейчас!</p>
            <form action="{{ route('search_main') }}" method="POST" class="d-flex search_for_emp_function form_searches searches_user" role="search">
                @csrf
                <input type="hidden" name="search_query" id="search_query_hidden">
                <input class="form-control search_inp search_inp3" type="search" id="search_input" placeholder="Водитель-курьер" aria-label="Search">
                <button class="btn_bigger" type="submit">Найти работу</button>
                <button class="btn_search" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <div class="often_search_block">
                <p class="often_search_p mulish16r ">Например:</p>
                <button class="pink_bg fz12 mulishr fff">Грузчик</button>
                <button class="green_bg fz12 mulishr fff">Начальник</button>
                <button class="brown_bg fz12 mulishr fff">Продавец-консультант</button>
            </div>
        </div>
</section>


<section class="recommended_vacancy_main_area">
    <div class="container_main">
        <div class="recommended_vacancy_main_block" data-aos="fade-right">
            <p class="recommended_vacancy_main_block_h">Вакансии дня</p>
            <div class="vacancy-grid">
                @foreach($randomVacancies as $vacancy)
                <div class="vacancy-item">
                    <a href="{{ route('show', $vacancy->id) }}" class="recommended_vacancy_main_title">{{ $vacancy->title }}</a>
                    <p class="recommended_vacancy_main_salary">от {{ number_format($vacancy->salary_from, 0, '.', ' ') }} ₽</p>
                    <p class="recommended_vacancy_main_company"><a class="recommended_vacancy_main_company" href="{{ route('emp.profile', ['companyId' => $vacancy->company->id]) }}" >{{ $vacancy->company->name }}</a>,@if ($vacancy->region) {{ $vacancy->region->name }} @endif</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<section class="work_in_company_and_vacancy_of_the_day_area">
    <div class="container_main">
        <div class="work_in_company_main_block container-xl">
            <p class="work_in_company_main_block_h wicmbi_min">Работа в компаниях</p>
            <!-- РАБОТА В ВАКАНСИЯХ НА МАЛЕНЬКИХ ЭКРАНАХ -->
            <div class="vacancy-grid wicmbi_min">
                @foreach($randomCompanies as $company)
                <div class="vacancy-item wicmbi_min_inner d-flex flex-column text-center">
                    <img src="{{ asset('storage/' . $company->logo) }}" class="img_logos_company_small" alt="">
                    <a href="{{ route('emp.profile', ['companyId' => $company->id]) }}" class="mulishr wicmbi_min_inner_a">{{ $company->name }}</a>
                    <p class="mulishr wicmbi_min_inner_v">Вакансий: {{ $company->jobs()->where('status', 'Активна')->count() }}</p>
                </div>
                @endforeach
            </div>

            <div class="work_in_company_main_block_inner wicmbi">
                <p class="work_in_company_main_block_h">Работа в компаниях</p>
                <img src="{{ asset('img/photo/promo.svg')}}" alt="" class="work_in_company_main_block_img">
    
                <div class="work_in_company_main_group">
                    @foreach($randomCompanies as $company)
                    <div class="work_in_company_main_group_inner">
                        <a href="{{ route('emp.profile', ['companyId' => $company->id]) }}" class="work_in_company_main_group_inner_name">{{ $company->name }}</a>
                        <p class="work_in_company_main_group_inner_count_vacancys">{{ $company->jobs()->where('status', 'Активна')->count() }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
            
            <div class="vacancy_of_the_day_block">
                <div class="vacancy_of_the_day_block_inner">
                    <p class="vacancy_of_the_day_block_h">Вакансии дня в Москве</p>

                    <div class="vacancy_of_the_day_main_group">
                        @foreach($moreRandomVacancies as $vacancy)
                        <div class="vacancy_of_the_day_main_group_inner">
                            <a href="{{ route('show', $vacancy->id) }}" class="vacancy_of_the_day_main_group_inner_title">{{ $vacancy->title }}</a>
                            <p class="vacancy_of_the_day_main_group_inner_salary">от {{ number_format($vacancy->salary_from, 0, '.', ' ') }} до {{ number_format($vacancy->salary_to, 0, '.', ' ') }}  ₽</p>
                            <p class="vacancy_of_the_day_main_group_inner_company">
                                <a class="vacancy_of_the_day_main_group_inner_company" href="{{ route('emp.profile', ['companyId' => $vacancy->company->id]) }}">
                                    {{ $vacancy->company->name }}
                                </a>, @if ($vacancy->region) {{ $vacancy->region->name }} @endif
                            </p>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>




        </div>
    </div>
</section>


<section class="news_articles_useful_area container-xl">
        <hr class="hr_blue">

        <div class="news_articles_useful_group_blocks">
            <div class="d-none news_articles_useful_block naub1">
                <p class="news_articles_useful_group_block_h">Новости</p>

                <div class="news_articles_useful_group_block_inner border_bottom_blue">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Как стать профессиональным гидом в Москве</p>
                </div>

                <div class="news_articles_useful_group_block_inner border_bottom_blue">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Многодетность навсегда: новый подход к большим семьям</p>
                </div>

                <div class="news_articles_useful_group_block_inner border_bottom_blue">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Молодёжь-2030: как государство помогает выбрать профессию</p>
                </div>

                <div class="news_articles_useful_group_block_inner">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Топ-10 профессий в медицине для выпускников ссузов</p>
                </div>

            </div>

            <div class="d-none news_articles_useful_block naub2 border_left_blue">
                <p class="news_articles_useful_group_block_h">Статьи</p>

                <div class="news_articles_useful_group_block_inner border_bottom_blue">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Как стать профессиональным гидом в Москве</p>
                </div>

                <div class="news_articles_useful_group_block_inner border_bottom_blue">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Многодетность навсегда: новый подход к большим семьям</p>
                </div>

                <div class="news_articles_useful_group_block_inner border_bottom_blue">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Молодёжь-2030: как государство помогает выбрать профессию</p>
                </div>

                <div class="news_articles_useful_group_block_inner">
                    <img src="#" class="news_articles_useful_group_block_inner_img" alt="">
                    <p class="news_articles_useful_group_block_inner_p">Топ-10 профессий в медицине для выпускников ссузов</p>
                </div>
            </div>

            <div class="news_articles_useful_block naub3">
                <p class="news_articles_useful_group_block_h">Полезное</p>

                <div class="news_articles_useful_block_inner_list">

                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="1">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере авто бизнеса</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="2">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере IT</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="3">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере медицины</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="4">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере строительства</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="5">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере туризма</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="6">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере маркетинга</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="7">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере образования</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="8">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере логистики</button>
                    </form>
                    <form action="{{ route('vacancies_by_specialization') }}" method="GET">
                        @csrf
                        <input type="hidden" name="specialization_id" value="9">
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в сфере финансов</button>
                    </form>

                </div>
                
            </div>
            <div class="news_articles_useful_block naub4 border_left_blue">

                <p class="news_articles_useful_group_block_h">Работа в других городах</p>

                <div class="news_articles_useful_block_inner_list">
                    
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="1"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Москве</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="2"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Санкт-Петербурге</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="3"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Новосибирске</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="4"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Екатеринбурге</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="5"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Нижнем Новгороде</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="6"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Казани</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="7"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Челябинске</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="12"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Красноярске</button>
                    </form>
                    <form action="{{ route('vacancies_by_region') }}" method="GET">
                        @csrf
                        <input type="hidden" name="region_id" value="17"> <!-- Значение региона -->
                        <button type="submit" class="news_articles_useful_block_inner_list">Работа в Саратове</button>
                    </form>

                </div>
                
            </div>
        </div>
        <hr class="hr_blue">
</section>

<section class="work_in_country_info_area">
    <div class="container_main">
        <div class="work_in_country_info_block container-xl">
            <p class="work_in_country_info_block_h">Работа в России</p>

            <p class="work_in_country_info_block_inner">Работа составляет большую часть жизни почти каждого из нас. Но ничто не вечно: случается, что однажды приходится менять место работы и с головой погружаться в поиски вакансий — хочется ведь найти хорошую альтернативу текущей должности.</p>

            <p class="work_in_country_info_block_inner">Однако зачастую при смене работы мы задумываемся не только о смене компании, но и об изменении профессиональной деятельности. И именно в эти моменты возникает вопрос: «Как теперь найти хорошую работу в Москве? А главное, какой должна быть эта работа?»</p>
            <p class="work_in_country_info_block_inner">Чтобы решать такие вопросы легко и быстро, достаточно всего лишь зайти на JobWave!</p>
            <p class="work_in_country_info_block_inner">На нашем сайте вы всегда можете узнать последние новости рынка труда, а также изучить свежий обзор зарплат, с помощью которого легко оценить, на какие должности стоит нацелиться. Если вы уже определились, вакансии каких специальностей вас интересуют, вам остаётся только создать резюме и приступать к поиску работы мечты!</p>
            <p class="work_in_country_info_block_inner">Удобнее всего искать работу с помощью нашего каталога вакансий: всего пару раз кликнув мышкой, вы получите список актуальных и качественных вакансий в Москве или другом регионе России. Но это не единственный вариант поиска работы. На нашем сайте вы можете создать привлекательное резюме, и вакансии сами начнут стекаться к вам! А скомбинировав оба эти метода, вы сможете получить наиболее быстрый, а главное, эффективный способ поиска работы!</p>

        </div>
    </div>
</section>




<script>
    
</script>













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