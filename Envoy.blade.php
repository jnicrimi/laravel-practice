@servers(['localhost' => '127.0.0.1'])

@task('clear-cache', ['on' => 'localhost'])
    php artisan clear-compiled
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
@endtask
