#!/bin/sh

# Install dependencies if vendor directory is missing
if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Install npm dependencies and build frontend if node_modules is missing
if [ ! -d "node_modules" ]; then
    npm install
    npm run build
fi

# Run migrations
php artisan migrate --force

# Cache configuration and routes
php artisan optimize

# Start the main process
exec "$@"
