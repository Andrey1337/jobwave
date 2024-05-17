<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class ApplicantAuthController extends Controller
{
    // Метод для отображения формы регистрации соискателя
    public function showRegistrationForm()
    {    
        $regions = Region::all(); // Получаем список всех регионов из базы данных
        return view('auth.register_applicant', compact('regions'));
    }

   

    // Метод для обработки запроса регистрации соискателя
    public function register(Request $request)
    {
            // Валидация данных
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'gender' => 'required|in:Мужчина,Женщина',
                'birth_date' => 'required|date|before_or_equal:'.now()->subYears(14)->format('Y-m-d').'|after_or_equal:'.now()->subYears(99)->format('Y-m-d'),
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'region_id' => 'required|exists:regions,id', // Используем region_id
                'status' => 'required|in:Активно ищу работу,Рассматриваю предложения,Не ищу работу',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'birth_date' => 'Поле "Дата рождения" обязательно для заполнения .',
                'birth_date.before_or_equal' => 'Возраст должен быть от 14 до 99 лет.',
                'birth_date.after_or_equal' => 'Возраст должен быть от 14 до 99 лет.',
                'first_name.required' => 'Поле "Имя" обязательно для заполнения.',
                'last_name.required' => 'Поле "Фамилия" обязательно для заполнения.',
                'gender.required' => 'Поле "Пол" обязательно для заполнения.',
                'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
                'email.required' => 'Поле "Email" обязательно для заполнения.',
                'email.unique' => 'Такой Email уже зарегистрирован.',
                'city.required' => 'Поле "Город" обязательно для заполнения.',
                'region_id.required' => 'Поле "Регион" обязательно для заполнения.',
                'region_id.exists' => 'Выбранный регион не существует.',
                'status.required' => 'Поле "Статус" обязательно для заполнения.',
                'password.required' => 'Поле "Пароль" обязательно для заполнения.',
                'password.min' => 'Пароль должен содержать не менее :min символов.',
                'password.confirmed' => 'Подтверждение пароля не совпадает.',
            ]);

            // Создание нового пользователя
            $user = new User([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'gender' => $validatedData['gender'],
                'birth_date' => $validatedData['birth_date'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'region_id' => $validatedData['region_id'], // Используем region_id вместо city
                'status' => $validatedData['status'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Сохранение пользователя в базе данных
            $user->save();

            // Авторизация пользователя
            auth()->login($user);

            // Редирект пользователя после успешной регистрации
            return redirect()->route('dashboard_user');

    }

    // Метод для отображения формы входа соискателя
    public function showLoginForm()
    {
        return view('auth.login_applicant');
    }

    // Метод для обработки запроса входа соискателя
    public function login(Request $request)
    {
            // Валидация данных
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Попытка аутентификации пользователя
            if (Auth::attempt($credentials)) {
                // Если аутентификация успешна, перенаправляем пользователя на его личную страницу
                return redirect()->route('dashboard_user');
            } else {
                // Если аутентификация не удалась, перенаправляем пользователя обратно на страницу входа с сообщением об ошибке
                return redirect()->route('applicant.login')->withErrors(['email' => 'Неверный адрес электронной почты или пароль.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Выход из системы для текущего пользователя

        $request->session()->invalidate(); // Очистка текущей сессии пользователя

        $request->session()->regenerateToken(); // Генерация нового токена для текущей сессии

        return redirect()->route('main_for_user'); // Редирект на главную страницу или куда угодно
    }
}
