# Как запустить проект (Инструкция)

Ошибка `no configuration file provided` возникает потому, что `docker-compose.yml` находится внутри папки `payment-processor`, а вы запускаете команду из корня.

### Шаг 1: Перейдите в папку проекта
```bash
cd payment-processor
```

### Шаг 2: Запуск всей инфраструктуры (с пересборкой)
Я добавил файл `artisan` и поддержку `npm` в контейнер. Пересоберите проект:
```bash
docker-compose up -d --build
```

### Шаг 3: Установка зависимостей внутри контейнера
После того как контейнеры поднимутся:
```bash
# Установка PHP пакетов
docker exec -it payment-app composer install

# Установка JS пакетов и сборка фронтенда
docker exec -it payment-app npm install
docker exec -it payment-app npm run build

# Настройка Laravel
docker exec -it payment-app php artisan key:generate
docker exec -it payment-app php artisan migrate --seed
```

### Шаг 4: Проверка
- **Dashboard**: [http://localhost:8000](http://localhost:8000)
- **Horizon (Очереди)**: [http://localhost:8000/horizon](http://localhost:8000/horizon)
- **Health Check**: [http://localhost:8000/api/health](http://localhost:8000/api/health)

---
**Что я добавил только что:**
- `composer.json` и `package.json` (список всех зависимостей).
- `bootstrap/app.php` и `public/index.php` (ядро Laravel 11).
- `HandleInertiaRequests.php` (прослойка для работы фронтенда).
