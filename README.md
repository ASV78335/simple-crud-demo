# Simple CRUD demo

## Установка

1. Выполнить `git clone https://github.com/ASV78335/simple-crud-demo` to clone the project
2. Запустить демон docker
3. Выполнить `docker-compose up -d` для создания и запуска контейнера
4. Выполнить `php bin/console doctrine:migrations:migrate` для создания таблиц БД
5. Запустить веб-сервер `symfony server:start`

## Команды

### Создание:

curl --location 'https://127.0.0.1:8000/api/v1/person' \
--header 'Content-Type: application/json' \
--data-raw '{
"name": "Test name",
"email": "test10@mail.ru",
"birthday": "1900-01-10",
"sex": "female",
"phone": "12345678"
}'

поля name и email являются обязательными

### Изменение:

curl --location 'https://127.0.0.1:8000/api/v1/person/{uuid}' \
--header 'Content-Type: application/json' \
--data-raw '{
"name": "Test name",
"email": "test@mail.ru",
"birthday": "2011-11-11",
"sex": "male"
}'

### Удаление:

curl --location --request DELETE 'https://127.0.0.1:8000/api/v1/person/{uuid}' \
--data ''

### Просмотр:

curl --location 'https://127.0.0.1:8000/api/v1/person/{uuid}'
