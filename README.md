Простой менеджер задач <br>
PHP 8, Laravel 10, MySQL, Vue.js, Bootstrap 5 <br>
<a href="https://tasks-manager.ru">TaskTracker</a>

1. склонировать проект
2. перейти в дирректорию с проектом
3. сформировать .env
    DB_CONNECTION=mysql
    DB_HOST=tt_mysql        -- как container_name в docker-compose.yml
    DB_PORT=3306
    DB_DATABASE=tasktracker -- как в docker-compose.yml
    DB_USERNAME=non-root    -- как в docker-compose.yml
    DB_PASSWORD=root        -- как в docker-compose.yml
4. cd ./docker
5. sudo docker-compose up --build (sudo docker-compose up для последующих запусков)
6. в новой вкладке открываем еще один терминал
7. sudo docker exec -itu root tt_php bash   (tt_php как container_name в docker-compose.yml)
8. chmod -R 777 ./storage
9. php artisan migrate
10. можно проверять проект
