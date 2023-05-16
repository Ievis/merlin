### Инструкция для запуска проекта.

#### 1. Поднять контейнеры.

#### `docker-compose up -d`

#### 2. Создать схему БД с помощью doctrine-orm.

#### `docker exec -it merlin_app php bin/doctrine orm:schema-tool:create`

#### 3. Запустить supervisor.

#### `docker exec -it merlin_app supervisord`

#### Готово!

##### 1. `localhost:8000` - nginx/fpm/php

##### 2. `localhost:8080` - phpMyAdmin

##### 3. `mysql:3306` - MySQL