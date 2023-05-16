### Инструкция для запуска проекта.

#### 1. Установить зависимости composer.

`composer install`

#### 2. Поднять контейнеры.

`docker-compose up -d`

#### 3. Создать схему БД с помощью doctrine-orm.

`docker exec -it merlin_app php bin/doctrine orm:schema-tool:create`

#### 3.1. Если не удалось создать схему БД.

`docker-compose up -d --build db`

`docker exec -it merlin_app php bin/doctrine orm:schema-tool:create`

#### 4. Запустить supervisor.

`docker exec -it merlin_app supervisord`

`docker exec -it merlin_app supervisorctl status`

#### 5. Разрешить сохранение файлов в папку resources.

`sudo chmod -R 777 resources`

#### Готово!

1. `localhost:8000` - nginx/fpm/php
2. `localhost:8080` - phpMyAdmin `(логин - root, пароль - root)`
3. `mysql:3306` - MySQL