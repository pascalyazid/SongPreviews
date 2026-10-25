FROM php:8.5.12-cli-alpine3.23

WORKDIR /app

COPY . /app

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]
