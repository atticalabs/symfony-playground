#!/bin/bash

OS := $(shell uname)
DOCKER_BE = symfony-playground-be

#ifeq ($(OS),Darwin)
#UID = $(shell id -u)
#else ifeq ($(OS),Linux)
#UID = $(shell id -u)
#else
#UID = 1000
#endif

UID = 1000 #Windows

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
# En caso que se corra en Linux o Mac, descomentar y crear .yaml para esos entornos, ver https://bitbucket.org/juanwilde/sf5-expenses-api/src/5d07e74988543272786a6fc859836162e79bab3c/docker-compose.linux.yml?at=section2%2Fvideo1-docker-config
# ifeq ($(OS),Darwin)
# U_ID=${UID} docker-compose -f docker/docker-compose.macos.yml up -d pepe
# U_ID=${UID} docker-sync start
# else
	U_ID=${UID} docker-compose -f docker/docker-compose.yaml up -d 
# endif

recreate: ##Recrea contenedores y levanta DB posrgres si no existe
	U_ID=${UID} docker-compose -f docker/docker-compose.yaml down
	U_ID=${UID} docker-compose -f docker/docker-compose.yaml up -d --force-recreate

stop: ## Stop the containers
# ifeq ($(OS),Darwin)
# 	U_ID=${UID} docker-compose -f docker/docker-compose.macos.yml stop
# 	U_ID=${UID} docker-sync stop
# else
	U_ID=${UID} docker-compose -f docker/docker-compose.yaml stop
# endif

# docker-sync es para Mac -> lo hace mas rapido
# docker-sync-restart: ## Rebuild docker-sync stack and prepare environment
# 	U_ID=${UID} docker-sync-stack clean
# 	$(MAKE) run
# 	$(MAKE) prepare

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
# ifeq ($(OS),Darwin)
# 	U_ID=${UID} docker-compose -f docker/docker-compose.macos.yml build --compress --parallel
# else
	U_ID=${UID} docker-compose -f docker/docker-compose.yaml build
# endif

prepare: ## Runs backend commands
	$(MAKE) be-sf-permissions
	$(MAKE) composer-install
#	$(MAKE) migrations

#Kubernetes commands
kubs-up:
	helm install symfony-playground-db ./kubernetes/resources/dev/services/database/
	helm install symfony-playground-be ./kubernetes/resources/dev/services/backend/
	helm install symfony-playground-web ./kubernetes/resources/dev/services/web-server/ 
	#The following command displays the port where the svc is accessible
	kubectl get services/symfony-playground-web -o custom-columns=EXTERNAL_PORT:.spec.ports[0].nodePort

kubs-delete:
	helm uninstall symfony-playground-web
	helm uninstall symfony-playground-be
	helm uninstall symfony-playground-db

# Backend commands
be-sf-permissions: ## Configure the Symfony permissions
	U_ID=${UID} docker exec -it -uroot ${DOCKER_BE} sh /usr/bin/sf-permissions

composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

migrations:##
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php bin/console make:migration

apply-migrations: ## Runs the migrations
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php bin/console doctrine:migrations:migrate -n

be-logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} tail -f var/log/dev.log
# End backend commands

ssh-be: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony
#	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} php-cs-fixer fix tests --rules=@Symfony

generate-ssh-keys: ## Generate ssh keys in the container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} mkdir -p config/jwt
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} openssl genrsa -passout pass:symfony-playground -out config/jwt/private.pem -aes256 4096
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} openssl rsa -pubout -passin pass:symfony-playground -in config/jwt/private.pem -out config/jwt/public.pem
