<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/logo.svg') }}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>JobWave</title>
</head>
<body>
    <div class="top_header w-100 container-fluid d-flex justify-content-end">
        <a href="{{route('main_for_user')}}" class="p_top_header btn_text14">Соискателям</a>
        <a href="{{route('main_for_emp')}}" class="p_top_header btn_text14">Работодателям</a>
    </div>

<header class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid container_main">
            <div class="logo_block">
                <img src="img/logo/logo.svg" class="logo_img_header img-fluid" alt="logo">
                <a href="{{route('main_for_emp')}}" class="navbar-brand logo_p k2dr fs-2 c252">JobWave</a>
            </div>
            

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end justify-content-md-start justify-content-sm-start " id="navbarNav">
            <ul class="navbar-nav align-items-center">
                
                <li class="nav-item">
                <a class="nav-link mulish16r m-auto btn_stock mulish14b" href="#">Разместить вакансию</a>
                </li>
                <li class="nav-item auths_btns m-auto">
                <a class="nav-link mulish16r" href="#">Вакансии</a>
                </li>
                <li class="nav-item">
                <a class="nav-link mulish16r" href="#">О нас</a>
                </li>
                <li class="nav-item">
                <a class="nav-link mulish16r" href="#">Контакты</a>
                </li>
                <li class="nav-item auths_btns m-auto">
                <a class="nav-link mulish16r" href="{{route('login_employer')}}">Вход</a>
                </li>
                <li class="nav-item">
                <a class="nav-link mulish16r" href="{{route('register_employer')}}">Регистрация</a>
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
            <img src="img/logo/logo_footer.svg" class="logo_img_header img-fluid" alt="logo">
            <a href="{{route('main_for_emp')}}" class="navbar-brand logo_footer k2dr fs-2 c252">JobWave</a>
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
            <a href="#" class="footer_link"><img src="img/footer/vk.svg" alt="vk"></a>
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
<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
</body>
</html>