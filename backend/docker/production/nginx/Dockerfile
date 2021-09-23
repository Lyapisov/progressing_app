FROM nginx:1.21-alpine

COPY ./docker/production/nginx/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

COPY ./public ./public
