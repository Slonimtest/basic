<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

# Сервис коротких ссылок на Yii2

Простой веб-сервис для сокращения URL и генерации QR-кодов. Реализовано на фреймворке Yii2 с использованием Bootstrap и jQuery.

## Возможности

- Сокращение длинных URL
- Генерация QR-кода для сокращённой ссылки
- Учёт переходов по ссылке
- Валидация URL
- Простая и удобная форма

---

## Установка

### 1. Клонируйте репозиторий
```bash
git clone https://github.com/your-name/short-url-service.git
cd short-url-service
```
### 2. Установите зависимости через Composer
```bash
composer install
```
### 3. Настройте конфигурацию базы данных

Отредактируйте файл config/db.php:
```bash
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=short_urls',
    'username' => 'your_db_user',
    'password' => 'your_db_password',
    'charset' => 'utf8',
];
```
### 4. Запустите миграции для создания таблиц
```bash
php yii migrate
```
### 5. Установите права на папки (для Linux/Unix)
```bash
chmod -R 775 runtime/ web/assets/
```
## Запуск
### Через встроенный PHP сервер Yii:
```bash
php yii serve
```
### Затем откройте в браузере:
```bash
http://localhost:8080
```
Если используете Apache или Nginx — настройте виртуальный хост, указывающий на папку web/