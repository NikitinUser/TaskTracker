Простой менеджер задач <br>
PHP 8, Laravel 10, MySQL, Vue.js, Bootstrap 5 <br>

1. склонировать проект
2. перейти в дирректорию с проектом
3. сформировать env для docker
4. сформировать .env для laravel
    DB_CONNECTION=mysql
    DB_HOST=tt_mysql        -- как container_name в docker-compose.yml
    DB_PORT=3306
    DB_DATABASE=${DB_NAME} -- как в env для docker-compose.yml
    DB_USERNAME=${DB_USER} -- как в env для docker-compose.yml
    DB_PASSWORD=${DB_PASS} -- как в env для docker-compose.yml
5. cd ./docker
6. sudo docker-compose up --build (sudo docker-compose up для последующих запусков)
7. в новой вкладке открываем еще один терминал
8. sudo docker exec -itu root tt_php bash   (tt_php как container_name в docker-compose.yml)
9. php artisan key:generate
10. chmod -R 777 ./storage (если есть ошибки доступа к папке)
11. php artisan migrate
12. <a href="https://github.com/NikitinUser/userManagementModule">Выполнить 3-4 пункты<a>
13. можно проверять проект
