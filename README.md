Простой менеджер задач <br>
PHP 8.1, Laravel 10, Vue 3 <br>

1. git clone https://github.com/NikitinUser/TaskTracker.git
2. cd TaskTracker
3. env
    cp ./backend/'.env.example' ./backend/'.env'
    cp ./frontend/'.env.example' ./frontend/'.env'
4. frontend
    // todo npm ci унести в докер
    cd ./frontend/docker
    sudo docker-compose up --build
    cd ./../../
5. backend
    // todo composer install, php artisan key:generate унести в докер
    cd ./backend/docker
    sudo docker-compose up --build
    cd ./../../
6. если есть ошибки доступа к папке storage
    // todo выдать права на папку для приложения при сборке докера
    в новой вкладке открываем еще один терминал
    cd ./backend/docker
    sudo docker exec -itu root tt_php bash   (tt_php как container_name в docker-compose.yml)
    chmod -R 777 ./storage ()
7. можно проверять проект
