<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/logo.svg') }}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>

    <title>JobWave</title>
</head>
<body>
    <div class="top_header d-none w-100 container-fluid d-flex justify-content-end">
        <a href="{{route('main_for_user')}}" class="p_top_header btn_text14">Соискателям</a>
        <a href="{{route('main_for_emp')}}" class="p_top_header btn_text14">Работодателям</a>
    </div>

<header class="header">
        <nav class="navbar mt-5 p-0 border-0 navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid container_main">
            <div class="logo_block">
                <a href="{{route('login_employer')}}"><img src="{{ asset('img/logo/logo.svg')}}" class="logo_img_header img-fluid" alt="logo"></a>
                <a href="{{route('login_employer')}}" class="navbar-brand logo_p k2dr fs-2 c252">JobWave</a>
            </div>
            

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end justify-content-md-start justify-content-sm-start " id="navbarNav">
            <ul class="navbar-nav align-items-center navbar-nav-after_auth_emp">

                <div class="others_links_block flex-wrap flex-lg-nowrap flex-column flex-lg-row align-content-center align-items-center d-flex">
                    <li class="nav-item auths_btns m-auto">
                        <a class="nav-link mulish16r" href="{{route('vacancy_list')}}">Вакансии</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mulish16r" href="{{route('candidates')}}">Кандидаты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mulish16r" href="#">Помощь</a>
                    </li>
                </div>
               
                <div class="search_with_icon_profile_block align-items-center d-flex">
                    <li class="nav-item">
                        <a class="nav-link mulish16r search_with_text_link d-flex align-items-center" href="{{route('search_main')}}">
                            <img src="{{ asset ('img/icons/search_with_text.svg') }}" alt="#" class="search_with_text_icon">Поиск
                        </a>
                    </li>
                    <!-- <li class="nav-item ">
                        <a class="nav-link mulish16r" href="{{route('login_employer')}}">                    
                            <img src="{{ asset ('img/icons/employer_profile.svg') }}" alt="#" class="#">
                        </a>
                    </li>  -->
                  

                    <li class="nav-item d-none d-lg-block dropdown">
                        <a class="nav-link mulish16r dropdown-toggle" href="#" id="dropdownButton">
                            <img src="{{ asset('img/icons/employer_profile.svg') }}" alt="#" class="#">
                        </a>
                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a class="dropdown-item mulishr w-100 text-center" href="{{ route('login_employer') }}">Главная</a></li>
                            <li>
                                <form method="post" class="dropdown-item text-center" action="{{ route('logout_employer') }}">
                                    @csrf
                                    <button type="submit" class=" mulishr">Выйти</button> 
                                </form>
                            </li>
                            <li>
                                <button type="button" class="mulishr text-center" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                    Редактировать компанию
                                </button>
                            </li>
                            <li>
                                <button type="button" class="mulishr text-center" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                                    Изменить пароль
                                </button>
                            </li>
                            
                        </ul>
                    </li>
                    
                </div>
                
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link mulish16r" href="{{ route('login_employer') }}">Главная</a>
                </li>
                
                <!-- Для элемента "Выйти" -->
                <li class="nav-item d-block d-lg-none">
                    <form method="post" class="" action="{{ route('logout_employer') }}">
                        @csrf
                        <button class="nav-link mulish16r" type="submit">Выйти</button>
                    </form>
                </li>

                <li class="nav-item d-block d-lg-none">
                    <button type="button" class="m-2 m-xl-2 m-xxl-0 btn_outline_14 align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                        Редактировать компанию
                    </button>
                </li>

               

            </ul>
            </div>
        </div>
        </nav>
</header>
<main>
    @yield('content')
</main>



<footer class="footer">
    <div class="content_footer container_main w-100 row justify-content-xxl-center justify-content-xl-center justify-content-lg-center justify-content-md-normal container-md g-xl-0 g-xxl-0 g-lg-4 g-md-5 g-sm-5 g-xs-5  justify-content-sm-normal justify-content-xs-normal">
        <div class="logo_block_footer col d-xxl-flex d-xl-flex d-lg-none d-md-none d-sm-none d-xs-none">
            <img src="{{ asset ('img/logo/logo_footer.svg')}}" class="logo_img_header img-fluid" alt="logo">
            <a href="#" class="navbar-brand logo_footer k2dr fs-2 c252">JobWave</a>
        </div>

        <div class="links_footer d-flex flex-column col-2 col-lg-3 col-md-2 col-sm-2  w-auto">
            <a href="#" class="footer_link mulish16rfff">О компании</a>
            <a href="#" class="footer_link mulish16rfff">Новости</a>
            <a href="#" class="footer_link mulish16rfff">Поиск вакансий</a>
            <a href="#" class="footer_link mulish16rfff">Партнеры</a>
            <a href="#" class="footer_link mulish16rfff">Политика конфиденциальности</a>
        </div>

        <div class="links_footer d-flex flex-column col-2 col-lg-3 col-md-2 col-sm-2  w-auto">
            <a href="#" class="footer_link mulish16rfff">Вакансии</a>
            <a href="#" class="footer_link mulish16rfff">Вход/Регистрация</a>
            <a href="#" class="footer_link mulish16rfff">Помощь</a>
            <a href="#" class="footer_link mulish16rfff">Советы для соискателей</a>
        </div>

        <div class="links_footer d-flex flex-column col-2 col-lg-3 col-md-2 col-sm-2  w-auto">
            <a href="#" class="footer_link mulish16rfff">4ekagobro@mail.ru</a>
            <a href="#" class="footer_link mulish16rfff">+7-985-482-82-48</a>
        </div>

        <div class="links_footer d-flex flex-column col-2 col-lg-3 col-md-2 col-sm-2  w-auto">
            <a href="#" class="footer_link"><img src="{{ asset ('img/footer/vk.svg')}}" alt="vk"></a>
        </div>
        

    </div>
    <hr class="hr_footer container_hr img-fluid">

    <div class="container_main">
        <div class=" p_copyright k2dr">© 2024 JobWave</div>

        <div class=" p_copyright mulish16rfff">Сегодня на сайте {{ $vacancyCount }} вакансий, {{$resumesCount}} резюме, {{ $companyCount }} компаний</div>
    </div>
   
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Функция для добавления и удаления классов в зависимости от размера экрана
function toggleSearchButton() {
    var screenWidth = $(window).width();
    if (screenWidth < 768) {
        // Если ширина экрана меньше 768px, скрываем кнопку "Найти сотрудника" и показываем иконку поиска
        $('.btn_bigger').addClass('d-none').removeClass('d-block');
        $('.btn_search').addClass('d-block').removeClass('d-none');
        $('.search_inp').addClass('search_radius_tbr');
        $('.search_for_emp_function').removeClass('search_for_emp_function');
        $('.search_for_emp').addClass('search_for_emp_block_mobile').addClass('p-2').removeClass('search_for_emp_block');
    } else {
        // Если ширина экрана больше или равна 768px, скрываем иконку поиска и показываем кнопку "Найти сотрудника"
        $('.btn_search').addClass('d-none').removeClass('d-block');
        $('.btn_bigger').addClass('d-block').removeClass('d-none');
        $('.search_inp').removeClass('search_radius_tbr');
        $('.form_searches').addClass('search_for_emp_function');
        $('.search_for_emp').removeClass('search_for_emp_block_mobile').addClass('search_for_emp_block');
    }
}

// Вызываем функцию toggleSearchButton() при загрузке страницы и при изменении размера окна
$(document).ready(function() {
    toggleSearchButton(); // Вызов функции при загрузке страницы
    $(window).resize(function() {
        toggleSearchButton(); // Вызов функции при изменении размера окна
    });
});



</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownToggle = document.querySelectorAll('.dropdown-toggle');

        dropdownToggle.forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var dropdownMenu = this.nextElementSibling;
                var isShowing = dropdownMenu.classList.contains('show');

                // Скрыть все другие открытые выпадающие меню
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    if (menu !== dropdownMenu) {
                        menu.classList.remove('show');
                    }
                });

                // Переключить класс для отображения/скрытия выпадающего меню
                if (!isShowing) {
                    dropdownMenu.classList.add('show');
                } else {
                    dropdownMenu.classList.remove('show');
                }
            });

            // Скрыть выпадающее меню при клике вне элемента
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('#successAlert').fadeOut();
        }, 5000);
    });
</script>







</body>
</html>