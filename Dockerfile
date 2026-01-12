FROM php:8.2-apache

# Cài đặt các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite cho URL routing (QUAN TRỌNG!)
RUN a2enmod rewrite

# Cấu hình Apache để cho phép .htaccess override
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Fix warning ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory - đặt trong /CongNgheMoi để giống XAMPP
WORKDIR /var/www/html/CongNgheMoi

# Copy source code
COPY . .

# Tạo alias /CongNgheMoi trong Apache config
RUN echo '<Directory /var/www/html/CongNgheMoi>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Cài dependencies
RUN composer install --no-dev --optimize-autoloader

# Phân quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/CongNgheMoi/logs 2>/dev/null || true \
    && chmod -R 777 /var/www/html/CongNgheMoi/public/uploads 2>/dev/null || true

# Set biến môi trường cho Docker
ENV DOCKER_ENV=true

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
