#!/bin/sh
set -e
echo '>>> Running: php artisan migrate --force'
php artisan migrate --force
echo '>>> Creating storage symlink...'
php artisan storage:link --force
echo '>>> Migration done. Starting server...'
exec php artisan serve --host 0.0.0.0 --port ${PORT:-8080}
