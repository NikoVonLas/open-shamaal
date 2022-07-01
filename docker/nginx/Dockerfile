FROM nginx:stable-alpine

COPY ./nginx.local.conf /etc/nginx/nginx.conf
COPY ./game.conf /etc/nginx/conf.d/default.conf

COPY ./entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
