Простой менеджер задач <br>
PHP 8.1, Laravel 10, Vue 3 <br>

1. git clone https://github.com/NikitinUser/TaskTracker.git
2. cd TaskTracker
3. env
    cp ./backend/docker/'.env.example' ./backend/docker/'.env'
    cp ./backend/src/'.env.example' ./backend/src/'.env'
    cp ./frontend/docker/'.env.example' ./frontend/docker/'.env'
    cp ./frontend/src/'.env.example' ./frontend/src/'.env'
4. frontend
    cd ./frontend/src/
    npm ci
    cd ./../docker
    sudo docker-compose up --build
5. backend
    cd ./backend/src/
    composer install
    php artisan key:generate
    cd ./../docker
    sudo docker-compose up --build
6. если есть ошибки доступа к папке storage
    в новой вкладке открываем еще один терминал
    cd ./backend/docker
    sudo docker exec -itu root tt_php bash   (tt_php как container_name в docker-compose.yml)
    chmod -R 777 ./storage ()
7. можно проверять проект
