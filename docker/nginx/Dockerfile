FROM nginx:alpine

ADD api.conf /etc/nginx/conf.d/api.conf
ADD app.conf /etc/nginx/conf.d/app.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer