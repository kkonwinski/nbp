# Commands
REBUILD_CMD = docker-compose down && docker-compose build && docker-compose up -d
START_CMD = docker-compose up -d
STOP_CMD = docker-compose down

.PHONY: help nginx php rebuild start stop

# Help command
help:
	@echo "Available commands:"
	@echo "  nginx - Connects to the nginx container"
	@echo "  php - Connects to the PHP container"
	@echo "  rebuild - Rebuilds all containers"
	@echo "  start - Starts all containers"
	@echo "  stop - Stops all containers"

# Connect to nginx container
nginx:
	docker exec -it nginx bash

# Connect to PHP container
php:
	docker exec -it php bash

# Rebuild all containers
rebuild:
	$(REBUILD_CMD)

# Start all containers
start:
	$(START_CMD)

# Stop all containers
stop:
	$(STOP_CMD)
