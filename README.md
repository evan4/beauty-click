# beauty-click

Приложение vue (админка) и laravel (backend)

Пароль у пользователей secret12

## Развертывание проекта
Для установки php библиотек выпольнить
``` 
composer install
```
Далее выполнить для создания таблиц и генерации тестовых данных
```
php artisan migrate:fresh --seed
```
В корне проекта выполнить для установки зависимостей vue
```
npm install
```

### Запуск компилятора для разработки
В корне проекта выполнить
```
npm run watch-poll
```

### Однократный запуск компилятора.для production
```
npm run production
```

### Шаблон blade админ панели
/vendor/laravel/jetstream/resources/views/components/welcome.blade.php
