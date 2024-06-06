@extends(
    Auth::guard('web')->check() ? 
        'layouts.after_default_us' : 
        (Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)
@section ('content')
    <section class="help_page_area p-2 p-xl-2 p-xxl-0">
        <div class="container_main">
            <div class="about_company_blocks_group">

                <div class="about_company_block">
                    <p class="about_company_block_h">Политика конфиденциальности</p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">1. Введение</p>
                    <p class="about_company_block_p">
                    Добро пожаловать на JobWave! Мы заботимся о вашей конфиденциальности и стремимся защищать ваши личные данные. Настоящая Политика конфиденциальности объясняет, какие данные мы собираем, как мы их используем и какие у вас есть права в отношении ваших данных.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">2. Какие данные мы собираем</p>
                    <p class="about_company_block_p">
                    Личные данные, предоставляемые пользователями:
                    <ul>
                        <li class="li_privacy_policy">Имя, фамилия</li>
                        <li class="li_privacy_policy">Адрес электронной почты</li>
                        <li class="li_privacy_policy">Номер телефона</li>
                        <li class="li_privacy_policy">Резюме и все данные в нем</li>
                        <li class="li_privacy_policy">Другая информация, предоставляемая при регистрации и использовании сайта</li>
                    </ul>
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_p">
                    Данные, собираемые автоматически:
                    <ul>
                        <li class="li_privacy_policy">IP-адрес</li>
                        <li class="li_privacy_policy">Тип устройства и браузера</li>
                        <li class="li_privacy_policy">История посещений и взаимодействий с сайтом</li>
                        <li class="li_privacy_policy">Файлы cookie и аналогичные технологии</li>
                    </ul>
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">3. Как мы используем ваши данные</p>
                    <p class="about_company_block_p"> 
                    Для предоставления услуг:
                    <ul>
                        <li class="li_privacy_policy">Обработка регистраций и создание профилей</li>
                        <li class="li_privacy_policy">Размещение и управление вакансиями</li>
                        <li class="li_privacy_policy">Поиск и подбор вакансий и кандидатов</li>
                    </ul>
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_p">
                    Для улучшения наших услуг:
                    <ul>
                        <li class="li_privacy_policy">Анализ использования сайта для улучшения функциональности</li>
                        <li class="li_privacy_policy">Разработка новых функций и услуг</li>
                    </ul>
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">4. Как мы защищаем ваши данные</p>
                    <p class="about_company_block_p">
                        Мы принимаем все необходимые меры для защиты ваших данных от несанкционированного доступа, изменения, раскрытия или уничтожения. Мы используем современные технологии безопасности и регулярно обновляем наши процедуры для обеспечения максимальной защиты.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">5. Передача данных третьим лицам</p>
                    <p class="about_company_block_p">
                        Мы не передаем ваши личные данные третьим лицам, за исключением случаев, когда это необходимо для предоставления наших услуг или если это требуется по закону. Мы можем делиться данными с:
                        <ul>
                            <li class="li_privacy_policy">Партнерами, которые помогают нам в предоставлении услуг</li>
                            <li class="li_privacy_policy">Государственными органами, если это требуется законом</li>
                        </ul>
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">6. Ваши права</p>
                    <p class="about_company_block_p">
                        Вы имеете право:
                        <ul>
                            <li class="li_privacy_policy">Получить доступ к своим личным данным</li>
                            <li class="li_privacy_policy">Исправить неточные или устаревшие данные</li>
                            <li class="li_privacy_policy">Удалить свои данные (в определенных случаях)</li>
                            <li class="li_privacy_policy">Ограничить или возразить против обработки данных</li>
                            <li class="li_privacy_policy">Переносить данные</li>
                        </ul>
                    </p>
                    <p class="about_company_block_p">
                        Для реализации ваших прав, пожалуйста, свяжитесь с нами по контактам, указанным ниже.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">7. Использование файлов cookie</p>
                    <p class="about_company_block_p">
                        Мы используем файлы cookie и аналогичные технологии для улучшения работы сайта, анализа использования и предоставления персонализированного контента. Вы можете управлять настройками файлов cookie через настройки вашего браузера.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">8. Изменения в Политике конфиденциальности</p>
                    <p class="about_company_block_p">
                        Мы можем периодически обновлять эту Политику конфиденциальности. Все изменения будут опубликованы на этой странице, и мы рекомендуем регулярно проверять ее на предмет обновлений.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">9. Контакты</p>
                    <p class="about_company_block_p">
                        Если у вас есть вопросы или замечания по поводу этой Политики конфиденциальности, пожалуйста, свяжитесь с нами: <br><br>
                        Электронная почта: <a href="mailto:privacy@jobwave.ru?subject=Общий вопрос" class="blue_p">privacy@jobwave.ru</a>
                        <br><br>
                        Телефон: +7-985-482-82-48 <br><br>
                        Почтовый адрес: г. Москва, Дмитровское шоссе, 110А
                    </p>
                </div>
                
            </div>
        </div>
    </section>




@endsection