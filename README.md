# Complete Laravel Docker Setup and Startup Guide

## 📁 Project Structure Setup

First, ensure your project structure looks like this:

```
your-project/
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Nginx configuration
│   ├── php/
│   │   └── Dockerfile            # PHP-FPM container
│   └── mysql/
│       └── init/                 # Database initialization scripts
├── src/                          # Your Laravel application
│   ├── app/
│   ├── public/
│   ├── .env.example
│   └── ...
├── docker-compose.yml
├── Makefile
├── setup.sh
└── README.md
```

## 🚀 Method 1: Automated Setup (Recommended)

### For New Team Members

```bash
# Clone the repository
git clone <your-repo-url>
cd <your-project>

# Run the automated setup
chmod +x setup.sh
./setup.sh
```

The setup script will:

1. Create `.env` file with proper user permissions
2. Create Laravel `.env` from `.env.example`
3. Build Docker containers
4. Start all services
5. Install PHP dependencies
6. Generate application key
7. Run database migrations
8. Set proper permissions

## 🔧 Method 2: Manual Setup

### Step 1: Create Environment File

```bash
# Create .env file for Docker Compose
cat > .env << EOF
UID=$(id -u)
GID=$(id -g)
EOF
```

### Step 2: Prepare Laravel Environment

```bash
# Copy Laravel environment file
cp src/.env.example src/.env

# Edit src/.env with your database settings (should already match docker-compose.yml)
```

### Step 3: Build and Start Containers

```bash
# Build containers
make build

# Start services
make up
```

### Step 4: Install Dependencies and Setup Laravel

```bash
# Install PHP dependencies
make install

# Generate application key
make key

# Run migrations
make migrate

# Fix permissions
make fix-permissions
```

## 🐳 Docker Commands Breakdown

### Building Containers

```bash
# Build all containers
docker-compose build

# Build with no cache (fresh build)
docker-compose build --no-cache

# Build specific service
docker-compose build app
```

### Starting Services

```bash
# Start all services in background
docker-compose up -d

# Start with logs visible
docker-compose up

# Start specific service
docker-compose up -d app
```

### Checking Status

```bash
# View running containers
docker-compose ps

# View logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f app
```

## 🔍 Verification Steps

### 1. Check Container Status

```bash
make logs
# or
docker-compose ps
```

You should see all services running:

- `mfc_nginx` (nginx)
- `mfc_app` (php-fpm)
- `mfc_db` (mysql)

### 2. Test Database Connection

```bash
# Enter PHP container
make exec

# Test database connection
php artisan tinker
# In tinker:
DB::connection()->getPdo();
```

### 3. Check Web Access

- Visit: <http://localhost:9090>
- Should see Laravel welcome page or your application

### 4. Check Database Access

```bash
# Connect to database from host
mysql -h 127.0.0.1 -P 3307 -u mfc_user -p
# Password: secret
```

## 🛠️ Common Startup Issues and Solutions

### Issue 1: Permission Errors

```bash
# Fix Laravel storage permissions
make fix-permissions

# If still having issues, rebuild with your user ID
make build
```

### Issue 2: Database Connection Failed

```bash
# Check database logs
docker-compose logs db

# Restart database
docker-compose restart db

# Wait for database to be ready
make migrate
```

### Issue 3: Nginx 502 Bad Gateway

```bash
# Check if PHP-FPM is running
docker-compose logs app

# Restart PHP-FPM
docker-compose restart app
```

### Issue 4: Port Already in Use

```bash
# Check what's using the port
sudo netstat -tlnp | grep :9090

# Stop conflicting service or change port in docker-compose.yml
```

## 📝 Daily Development Workflow

### Starting Your Day

```bash
# Start all services
make up

# Check logs if needed
make logs
```

### Working with Laravel

```bash
# Enter container for artisan commands
make exec

# Run artisan commands
php artisan make:controller UserController
php artisan migrate
php artisan tinker
```

### Or use Makefile shortcuts

```bash
# Run artisan commands from host
make artisan CMD='make:controller UserController'
make artisan CMD='migrate:fresh --seed'

# Run composer commands
make composer CMD='require laravel/sanctum'
```

### Ending Your Day

```bash
# Stop all services
make down
```

## 🔄 Restart Process

If you need to restart everything:

```bash
# Complete restart
make restart

# Or manually:
make down
make up
```

## 🧹 Clean Restart

If you encounter persistent issues:

```bash
# Clean up everything and restart
make clean
make setup
```

## 📊 Health Check Commands

```bash
# Check all container status
docker-compose ps

# Check resource usage
docker stats

# Check container logs
make logs

# Test application response
curl http://localhost:9090

# Test database connection
make exec
php artisan tinker
DB::connection()->getPdo();
```

## 🎯 Success Indicators

You'll know everything is working when:

- ✅ `docker-compose ps` shows all services as "Up"
- ✅ <http://localhost:9090> loads your Laravel application
- ✅ Database connections work from Laravel
- ✅ No permission errors in logs
- ✅ You can run `make exec` and access the PHP container

## 🚨 Emergency Reset

If everything breaks:

```bash
# Nuclear option - removes all containers and volumes
make clean
docker system prune -a
./setup.sh
```

This will give you a completely fresh start!
