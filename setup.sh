#!/bin/bash

# Laravel Docker Development Setup Script
# This script sets up the development environment for new collaborators

set -e

echo "🐳 Setting up Laravel Docker development environment..."
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

# Determine Docker Compose command (binary vs plugin)
if command -v docker-compose &> /dev/null; then
    DC="docker-compose"
elif docker compose version &> /dev/null; then
    DC="docker compose"
else
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Check if make is installed
if ! command -v make &> /dev/null; then
    echo "❌ Make is not installed. Installing make..."
    
    # Detect OS and install make
    if [[ "$OSTYPE" == "linux-gnu"* ]]; then
        if command -v apt &> /dev/null; then
            sudo apt update && sudo apt install -y make
        elif command -v yum &> /dev/null; then
            sudo yum install -y make
        elif command -v dnf &> /dev/null; then
            sudo dnf install -y make
        else
            echo "❌ Cannot auto-install make. Please install it manually:"
            echo "   Ubuntu/Debian: sudo apt install make"
            echo "   CentOS/RHEL: sudo yum install make"
            exit 1
        fi
    elif [[ "$OSTYPE" == "darwin"* ]]; then
        if command -v brew &> /dev/null; then
            brew install make
        else
            echo "❌ Please install make manually:"
            echo "   xcode-select --install"
            echo "   or install Homebrew and run: brew install make"
            exit 1
        fi
    else
        echo "❌ Unsupported OS. Please install make manually."
        exit 1
    fi
    
    echo "✅ Make installed successfully!"
fi

# Check Docker permissions
if ! docker ps &> /dev/null; then
    echo "❌ Docker permission denied. Adding user to docker group..."
    sudo usermod -aG docker $USER
    echo "⚠️  You need to log out and log back in (or restart) for docker group changes to take effect."
    echo "   Then run this script again."
    echo "   Alternatively, run: newgrp docker"
    exit 1
fi


# Create .env file for docker-compose with user permissions
echo "📝 Creating .env file with user permissions..."
cat > .env << EOF
# User permissions for Docker containers
UID=$(id -u)
GID=$(id -g)

# Laravel environment (you can customize these)
APP_ENV=local
APP_DEBUG=true
EOF

# Copy Laravel .env.example to .env if it doesn't exist
if [ ! -f "./src/.env" ] && [ -f "./src/.env.example" ]; then
    echo "📝 Creating Laravel .env file..."
    cp ./src/.env.example ./src/.env
fi

# Create necessary directories
echo "📁 Creating necessary directories..."
mkdir -p ./src/storage/app/public
mkdir -p ./src/storage/framework/cache
mkdir -p ./src/storage/framework/sessions
mkdir -p ./src/storage/framework/views
mkdir -p ./src/storage/logs
mkdir -p ./src/bootstrap/cache

# Set proper permissions for Laravel directories
echo "🔧 Setting proper permissions..."
chmod -R 775 ./src/storage ./src/bootstrap/cache 2>/dev/null || true

# Build and start containers
echo "🏗️  Building Docker containers..."
make build

echo "🚀 Starting services..."
make up

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
sleep 10

# Install dependencies
echo "📦 Installing PHP dependencies..."
make install

# Generate application key
echo "🔑 Generating application key..."
make key

# Run migrations
echo "🗄️  Running database migrations..."
make migrate

# Create storage symbolic link
echo "🔗 Creating storage symbolic link..."
make artisan CMD='storage:link'

# Fix permissions again after setup
echo "🔧 Fixing final permissions..."
make fix-permissions

echo ""
echo "✅ Setup complete!"
echo ""
echo "🌐 Your Laravel application is running at: http://localhost:9090"
echo "🗄️  Database is available at: localhost:3307"
echo ""
echo "📚 Available commands:"
echo "  make up          - Start services"
echo "  make down        - Stop services"
echo "  make exec        - Enter PHP container"
echo "  make artisan     - Run artisan commands"
echo "  make logs        - View logs"
echo "  make help        - See all available commands"
echo ""
echo "🎉 Happy coding!"
