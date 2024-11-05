# Variables
DOCKER_COMPOSE_FILE := docker-compose.yml

# Commandes Make
.PHONY: build up down start stop logs clean

# Construire les images Docker définies dans docker-compose.yml
build:
	docker-compose up --build

# Démarrer les conteneurs en arrière-plan
up:
	docker-compose -f $(DOCKER_COMPOSE_FILE) up -d

# Arrêter les conteneurs sans les supprimer
stop:
	docker-compose -f $(DOCKER_COMPOSE_FILE) stop

# Redémarrer les conteneurs
start:
	docker-compose -f $(DOCKER_COMPOSE_FILE) start

# Afficher les logs des conteneurs
logs:
	docker-compose -f $(DOCKER_COMPOSE_FILE) logs -f

# Arrêter et supprimer les conteneurs, les réseaux et les volumes
down:
	docker-compose -f $(DOCKER_COMPOSE_FILE) down

# Nettoyer complètement le projet (supprimer les conteneurs, images et volumes)
clean: down
	docker-compose -f $(DOCKER_COMPOSE_FILE) down --rmi all --volumes --remove-orphans