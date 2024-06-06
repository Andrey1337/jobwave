@extends(
    Auth::guard('web')->check() ? 
        'layouts.after_default_us' : 
        (Auth::guard('company')->check() ? 'layouts.main_afterEMP' : 'layouts.default_for_users')
)
@section ('content')
    <section class="contacts_area p-2 p-xl-2 p-xxl-0">
        <div class="container_main">
            <div class="about_company_blocks_group">

                <div class="about_company_block">
                    <p class="about_company_block_h">Контакты</p>
                    <p class="about_company_block_h2">Адрес офиса</p>
                    <p class="about_company_block_p">
                    JobWave <br>
                    г. Москва, Дмитровское шоссе, 110А.
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">Телефон</p>
                    <p class="about_company_block_p">
                    +7-985-482-82-48
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">Электронная почта</p>
                    <p class="about_company_block_p">
                        Общие вопросы: <a href="mailto:info@jobwave.ru?subject=Общий вопрос" class="blue_p">info@jobwave.ru</a> <br>
                        Техническая поддержка: <a href="mailto:support@jobwave.ru?subject=Техническая поддержка" class="blue_p">support@jobwave.ru</a> <br>
                        Вопросы сотрудничества: <a href="mailto:partners@jobwave.ru?subject=Вопросы сотрудничества" class="blue_p">partners@jobwave.ru</a>
                    </p>
                </div>
                <div class="about_company_block">
                    <p class="about_company_block_h2">Карта проезда</p>
                    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Москва</a><a href="https://yandex.ru/maps/213/moscow/house/dmitrovskoye_shosse_110a/Z04YcwNkS0QBQFtvfXR5dnRmZg==/?ll=37.544662%2C55.887710&source=serp_navig&utm_medium=mapframe&utm_source=maps&z=19.53" style="color:#eee;font-size:12px;position:absolute;top:14px;">Дмитровское шоссе, 110А — Яндекс Карты</a><iframe src="https://yandex.ru/map-widget/v1/?ll=37.544662%2C55.887710&mode=whatshere&source=serp_navig&whatshere%5Bpoint%5D=37.544730%2C55.887951&whatshere%5Bzoom%5D=17&z=19.53" width="100%" height="500" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
                    </div>
                </div>
                
            </div>
        </div>
    </section>




@endsection