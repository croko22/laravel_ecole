FROM node:22-alpine AS assets-build
WORKDIR /var/www/html
COPY . /var/www/html/

RUN npm ci
RUN npm run build

FROM nginx:stable-alpine AS nginx
COPY /docker/vhost.conf /etc/nginx/conf.d/default.conf
COPY --from=assets-build /var/www/html/public /var/www/html/