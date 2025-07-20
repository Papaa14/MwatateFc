# Laravel Docker Development Commands
# Export user ID and group ID for consistent permissions across systems
export UID = $(shell id -u)
export GID = $(shell id -g)

.PHONY: help up down build restart exec logs install migrate seed artisan composer test clean

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
	docker-compose up -d

# Stop services
down:
	docker-compose down

# Build containers
build:
	docker-compose build --no-cache

# Restart services
restart: down up

# Execute commands in PHP container
exec:
	docker-compose exec app sh

# View logs
logs:
	docker-compose logs -f app

# Install PHP dependencies
install:
	docker-compose exec app composer install

# Run database migrations
migrate:
	docker-compose exec app php artisan migrate

# Run database seeders
seed:
	docker-compose exec app php artisan db:seed

# Run artisan commands
artisan:
	docker-compose exec app php artisan $(CMD)

# Run composer commands
composer:
	docker-compose exec app composer $(CMD)

# Run tests
test:
	docker-compose exec app php artisan test

# Generate application key
key:
	docker-compose exec app php artisan key:generate

# Clear caches
cache-clear:
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

# Fix permissions for storage and bootstrap/cache
fix-permissions:
	docker-compose exec app chmod -R 775 storage bootstrap/cache

# Clean up
clean:
	docker-compose down -v
	docker system prune -f

# Complete setup for new developers
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