# Variables
APP_NAME := laravel_ecole
NGINX_IMAGE := $(APP_NAME)-nginx
FPM_IMAGE := $(APP_NAME)-fpm

# Build targets
build-nginx:
	docker build -f docker/nginx.Dockerfile -t $(NGINX_IMAGE) .

build-fpm:
	docker build -f docker/fpm.Dockerfile -t $(FPM_IMAGE) .

build-all: build-nginx build-fpm

# Run containers (puertos de ejemplo, cámbialos según necesites)
run-nginx:
	docker run -d --name $(NGINX_IMAGE) -p 8080:80 $(NGINX_IMAGE)

run-fpm:
	docker run -d --name $(FPM_IMAGE) -p 9000:9000 $(FPM_IMAGE)

# Limpieza
stop:
	docker stop $(NGINX_IMAGE) $(FPM_IMAGE) || true

rm: stop
	docker rm $(NGINX_IMAGE) $(FPM_IMAGE) || true

rmi:
	docker rmi $(NGINX_IMAGE) $(FPM_IMAGE) || true

# Atajo: reconstruir todo desde cero
rebuild: rm rmi build-all
