# Laravel Docker Development Commands

# Dynamically detect docker-compose vs docker compose
DC := $(shell command -v docker-compose >/dev/null 2>&1 && echo docker-compose || echo docker compose)

# Export user ID and group ID for consistent permissions across systems
export UID := $(shell id -u)
export GID := $(shell id -g)

.PHONY: help up down build restart exec logs install migrate seed artisan composer test clean setup key cache-clear fix-permissions

# Default target
help:
	@echo "Available commands:"
	@echo "  make up          - Start all services"
	@echo "  make down        - Stop all services"
	@echo "  make build       - Build containers"
	@echo "  make restart     - Restart all services"
	@echo "  make exec        - Enter the PHP container"
	@echo "  make logs        - View container logs"
	@echo "  make install     - Install PHP dependencies"
	@echo "  make migrate     - Run database migrations"
	@echo "  make seed        - Run database seeders"
	@echo "  make artisan     - Run artisan commands (usage: make artisan CMD='make:model User')"
	@echo "  make composer    - Run composer commands (usage: make composer CMD='require package')"
	@echo "  make test        - Run tests"
	@echo "  make clean       - Clean up containers and volumes"
	@echo "  make setup       - Complete development setup"

# Start services
up:
	$(DC) up -d

# Stop services
down:
	$(DC) down

# Build containers
build:
	$(DC) build --no-cache

# Restart services
restart: down up

# Execute commands in PHP container
exec:
	$(DC) exec app sh

# View logs
logs:
	$(DC) logs -f app

# Install PHP dependencies
install:
	$(DC) exec app composer install

# Run database migrations
migrate:
	$(DC) exec app php artisan migrate

# Run database seeders
seed:
	$(DC) exec app php artisan db:seed

# Run artisan commands
artisan:
	$(DC) exec app php artisan $(CMD)

# Run composer commands
composer:
	$(DC) exec app composer $(CMD)

# Run tests
test:
	$(DC) exec app php artisan test

# Generate application key
key:
	$(DC) exec app php artisan key:generate

# Clear Laravel caches
cache-clear:
	$(DC) exec app php artisan cache:clear
	$(DC) exec app php artisan config:clear
	$(DC) exec app php artisan route:clear
	$(DC) exec app php artisan view:clear

# Fix permissions for Laravel
fix-permissions:
	$(DC) exec app chmod -R 775 storage bootstrap/cache

# Remove volumes, networks, etc.
clean:
	$(DC) down -v
	docker system prune -f

# Full setup for new developers
setup: build up install key migrate
	@echo "Setting up Laravel permissions..."
	@make fix-permissions
	@echo ""
	@echo "🚀 Development environment ready!"
	@echo "Access your application at: http://localhost:9090"
	@echo "Database is available at: localhost:3307"
	@echo ""
	@echo "Useful commands:"
	@echo "  make exec     - Enter container"
	@echo "  make logs     - View logs"
	@echo "  make artisan  - Run artisan commands"
