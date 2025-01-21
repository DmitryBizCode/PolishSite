# Вибираємо базовий образ з PHP та Apache
FROM php:8.1-apache

# Встановлюємо розширення MySQL для PHP
RUN docker-php-ext-install mysqli

# Копіюємо код проекту в контейнер
COPY . /var/www/html

# Налаштовуємо права доступу
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Відкриваємо порт 80
EXPOSE 80
