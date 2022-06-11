# Технологическая демонстрация

## **скачать проект**

                git clone git@github.com:alexbabashov/animals.git
## **Stack**

### Frontend

* HTML
* JavaScript
* CSS
* Vue.JS

### Backend

* php
* laravel
* mysql
* redis
* Docker

---

## **Задание**

Написать симулятор выращивателя животных.

Симулятор позволяет создать животное из имеющихся (например: кошка, собака, слон, питон).
Список существующих типов животных должен получаться запросом на бекенд.

Чтобы создать новое животное, пользователь нажимает на кнопку "создать новое животное".
После того, как животное было создано, оно должно начать расти (его картинка начинает увеличиваться).

Чем дольше оно живет, тем больше становится, пока не достигнет максимального размера для своего типа (или возраста).

Скорость, с которой растет животное, отличается от вида к виду (см. API бекенда).

Размеры животного должны изменяться на бекенде.

---

## **API**

* **Получить список всех доступных типов животных и их параметры**

Request

>GET /animals/kinds

Response

        {            
            "error": null,
            "data": 
                    [{
                        "kind": "cat",
                        "max_size": 25,
                        "max_age": 100,
                        "growth_factor": 1.3
                    }]
        }

* **Получить параметры животного для заданного типа животного**

Request

>GET /animals/kinds/:cat

Response

        {            
            "error": null,
            "data": 
                    [
                        "kind": "cat",
                        "max_size": 25,
                        "max_age": 100,
                        "growth_factor": 1.3
                    ]
        }

* **Получить список всех созданных(активных) животных и их параметры**

Request

>GET /animals/active

Response

        {            
            "error": null,
            "data": 
                    [{
                        "name": "Simon",
                        "kind": "cat",
                        "age": 1,
                        "size": 1
                    }]
        }

* **Получить параметры созданного животного**

Request

>GET /animals/active/:Simon

Response

        {
            "error": null,
            "data": 
                {
                    "name": "Simon",
                    "kind": "cat",
                    "age": 1,
                    "size": 1
                }
        }

* **Создать новое животное**

Request

>POST /animals/active

        {
            "name": "Simon",
            "kind": "cat"
        }

Response

        {
            "error": null,
            "data": 
                {
                    "name": "Simon",
                    "kind": "cat"
                    "age": 1,
                    "size": 1
                }
        }


* **Состарить животное**

Request

>POST /animals/age

        {
            "name": "Simon",            
        }

Response

        {
            "error": null,
             "data": 
                {
                    "name": "Simon",
                    "kind": "cat"
                    "age": 2,
                    "size": 2
                }
        }

---

## **Визуальный макет**

https://www.figma.com/file/rksi2Y8PXFMYqjQfsrWdTp/Demo

---

## **Для работы необходимо установить Docker**

https://docs.docker.com/engine/install/

## **Запуск приложения**

Создание и запуск контейнеров
        
        docker-compose -f ./.docker/docker-compose.yml up --build

Установка зависимостей

        docker exec test1-app npm install

        docker exec test1-app composer install

Создание и инициализация БД

        docker exec test1-app php artisan migrate:fresh --seed

Создание симлинков

_не корректно работает при запуске из Windows_

        docker exec test1-app php artisan storage:link

Сборка проекта

        docker exec test1-app npm run wpk-dev

Запус проекта

        http://localhost:8098/
## **Дополнительные возможности**

Получение IP адреса контейнеровнера для доступа из хостовой ОС

        docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' <id-container>


Пример тестов

        docker exec test1-app php artisan test
