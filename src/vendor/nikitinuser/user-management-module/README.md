# userManagementModule
Пакет для управления ролями и правами пользователей в Laravel приложении <br><br>
Точно работает для Laravel 8, может быть работает для Laravel 7, 9 <br><br>

Установка:<br>

<ul>
<li>1) Выполнить в терминале из корня проекта: composer require nikitinuser/user-management-module</li>

<li> 2) Прописать:
    <ul>
        <li>
            2.1) NikitinUser\UserManagementModule\UserManagementModuleProvider::class<br>
            в файл app.php
        </li>
        <li>
            2.2) 'role' => \NikitinUser\userManagementModule\lib\Middleware\RoleMiddleware::class,<br>
            в protected $routeMiddleware в классе App\Http\Kernel.php
        </li>
        <li>
            2.3) 'permission' => \NikitinUser\userManagementModule\lib\Middleware\PermissionMiddleware::class,<br>
            в protected $routeMiddleware в классе App\Http\Kernel.php
        </li>
    </ul>
</li>

<li>
    3) Запустить миграции<br>
    php artisan migrate --path=./vendor/nikitinuser/user-management-module/lib/database/migrations
</li>

<li>
    4) Опционально можно добавить роуты к страничкам на свой side-bar @include('user-management-module::sidebar')
</li>
</ul>