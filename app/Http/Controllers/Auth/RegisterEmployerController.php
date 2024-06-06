<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterEmployerController extends Controller
{
    
    public function showRegisterFormEmp()
    {
        return view('auth.register_employer');
    }



    public function register(Request $request){
        // Регистрация пользователя
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'industry' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'in:маленькая,средняя,большая'],
            'city' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string', 'in:Организация,Проект,Частное лицо,Самозанятый,Частный рекрутер,Кадровое агентство'],
            'logo' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Проверка, что это изображение и размер не превышает 2 Мб
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);
        
        
            if ($request->password !== $request->password_confirmation) {
               return back()->withErrors(['password_confirmation' => 'Пароли не совпадают']);
            }


        $company = new Company();
        $company->email = $request->email;
        $company->name = $request->name;
        $company->description = $request->description;
        $company->industry = $request->industry;
        $company->company_size = $request->company_size;
        $company->city = $request->city;
        $company->company_type = $request->company_type;
        
        // Обработка загрузки изображения
        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('logos', 'public'); // Путь к сохраненному файлу
            $company->logo = $imagePath;
        } else {
            // Если логотип не был загружен, установите путь к изображению по умолчанию
            $company->logo = 'logos/default_logo.svg'; // Путь к изображению по умолчанию
        }
        
        $company->password = Hash::make($request->password); // Хэширование пароля
        $company->subscription_level = 'Бесплатный'; // Установка уровня подписки по умолчанию
        $company->save();
    
        

        
        return redirect()->route('login_employer');
    }

    public function update(Request $request)
    {
        // Валидация данных из формы
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email,' . auth()->guard('company')->user()->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'industry' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'in:маленькая,средняя,большая'],
            'city' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string', 'in:Организация,Проект,Частное лицо,Самозанятый,Частный рекрутер,Кадровое агентство'],
            'logo' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Проверка, что это изображение и размер не превышает 2 Мб
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'logo.max' => 'Максимальный размер файла должен быть 2 Мб.',

        ]);

        // Получаем текущего авторизованного пользователя (компанию)
        $company = auth()->guard('company')->user();

        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('logos', 'public'); // Путь к сохраненному файлу
            $company->logo = $imagePath;
            $company->save();
        }
        // После успешного обновления, добавляем уведомление в сессию
        session()->flash('success', 'Данные компании успешно обновлены.');

        // Перенаправляем пользователя обратно на страницу профиля (или куда-либо еще)
        return redirect()->back();
    } 


    public function changePassword(Request $request)
{
    $request->validate([
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $company = auth()->guard('company')->user();

    $company->password = Hash::make($request->password);
    $company->save();

    session()->flash('success', 'Пароль успешно изменен.');

    return redirect()->back();
}
    

}
