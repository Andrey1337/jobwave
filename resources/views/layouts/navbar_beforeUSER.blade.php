<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"><!-- animation css blocks -->

    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/logo.svg') }}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>JobWave</title>
</head>
<body>
    <div class="back_image_nav_us d-none d-md-block"></div>
    <div class="top_header w-100 container-fluid d-flex justify-content-end">
        <a href="#" class="p_top_header btn_text14">Соискателям</a>
        <a href="{{ route('main_for_emp') }}" class="p_top_header btn_text14">Работодателям</a>
    </div>

    <header class=""> 
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg_body_for_img">
        <div class="container-fluid container_main">
            <div class="logo_block">
                <img src="img/logo/logo.svg" class="logo_img_header img-fluid" alt="logo">
                <a href="#" class="navbar-brand logo_p k2dr fs-2 c252">JobWave</a>
            </div>
            

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end justify-content-md-start justify-content-sm-start " id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link mulish16r m-auto btn_stock mulish14b" href="{{ route('applicant.resume.create') }}">Создать резюме</a>
                    </li>
                    <li class="nav-item auths_btns m-auto">
                        <a class="nav-link  nav_linkss mulish16r" href="#">Вакансии</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  nav_linkss mulish16r" href="#">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  nav_linkss mulish16r" href="#">Контакты</a>
                    </li>
                    <li class="nav-item auths_btns m-auto">
                        <a class="nav-link  nav_linkss mulish16r" href="{{route('applicant.login')}}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  nav_linkss mulish16r" href="{{route('applicant.register')}}">Регистрация</a>
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
            <a href="#" class="navbar-brand fff logo_footer k2dr fs-2">JobWave</a>
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
        $('.often_search_p').addClass('c252').removeClass('fff');
        $('.search_for_user_block_h').addClass('c252').removeClass('fff');
        
        $('.search_for_user_area_main').removeClass('search_for_user_area');
        $('.search_for_emp_block_second_main').removeClass('search_for_emp_block_second').addClass('search_for_emp_block');

        
    } else {
        // Если ширина экрана больше или равна 768px, скрываем иконку поиска и показываем кнопку "Найти сотрудника"
        $('.btn_search').addClass('d-none').removeClass('d-block');
        $('.btn_bigger').addClass('d-block').removeClass('d-none');
        $('.search_inp').removeClass('search_radius_tbr');
        $('.form_searches').addClass('search_for_emp_function');
        $('.search_for_emp').removeClass('search_for_emp_block_mobile').addClass('search_for_emp_block');

       
        $('.search_for_user_area_main').addClass('search_for_user_area');
        $('.search_for_emp_block_second_main').removeClass('search_for_emp_block').addClass('search_for_emp_block_second');

    }
}

// Вызываем функцию toggleSearchButton() при загрузке страницы и при изменении размера окна
$(document).ready(function() {
    toggleSearchButton(); // Вызов функции при загрузке страницы
    $(window).resize(function() {
        toggleSearchButton(); // Вызов функции при изменении размера окна
    });
});


function resizeBlocks1200() {
    var screenWidth = $(window).width();
    if (screenWidth < 1135) {
        // Если ширина экрана меньше 768px, скрываем кнопку "Найти сотрудника" и показываем иконку поиска
        $('.naub4').addClass('border_left_blue').removeClass('border_top_blue');
        
        
    } else {
        // Если ширина экрана больше или равна 768px, скрываем иконку поиска и показываем кнопку "Найти сотрудника"
        $('.naub4').removeClass('border_top_blue').addClass('border_left_blue');
        
    }

    if (screenWidth < 845) {
        // Если ширина экрана меньше 768px, скрываем кнопку "Найти сотрудника" и показываем иконку поиска
        $('.naub4').addClass('border_top_blue');
        $('.naub3').addClass('border_top_blue border_right_blue');
        $('.naub4').addClass('border_left_blue');
        $('.naub1').addClass('border_right_blue  border_bottom_blue');
        $('.naub2').addClass('border_bottom_blue');

    } else {
        // Если ширина экрана больше или равна 768px, скрываем иконку поиска и показываем кнопку "Найти сотрудника"
        $('.naub3').removeClass('border_top_blue border_right_blue');
        // $('.naub4').removeClass('border_left_blue');
        $('.naub1').removeClass('border_right_blue  border_bottom_blue');
        $('.naub2').removeClass('border_bottom_blue');

    }

    if (screenWidth < 680) {
        $('.wicmbi').addClass('d-none');
        $('.wicmbi_min').removeClass('d-none');


    } else {
        $('.wicmbi').removeClass('d-none');
        $('.wicmbi_min').addClass('d-none');

    }

    // if (screenWidth < 620) {
    //     // Если ширина экрана меньше 768px, скрываем кнопку "Найти сотрудника" и показываем иконку поиска
    //     $('.naub2').removeClass('border_left_blue');
    //     $('.naub4').removeClass('border_left_blue');
    //     $('.naub1').removeClass('border_right_blue');
    //     $('.naub3').removeClass('border_right_blue border_top_blue');

    // } else {
    //     $('.naub2').addClass('border_left_blue');
    //     $('.naub4').addClass('border_left_blue');
    //     $('.naub1').addClass('border_right_blue');
    //     $('.naub3').addClass('border_right_blue border_top_blue');
    // }
}

// Вызываем функцию toggleSearchButton() при загрузке страницы и при изменении размера окна
$(document).ready(function() {
    resizeBlocks1200(); // Вызов функции при загрузке страницы
    $(window).resize(function() {
        resizeBlocks1200(); // Вызов функции при изменении размера окна
    });
});   

</script>
<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>  
    AOS.init({
        once: true
    });

</script>
</body>
</html>