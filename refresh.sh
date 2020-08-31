composer dump-autoload
php artisan migrate:reset
php artisan migrate
php artisan db:seed
php artisan route:cache
php artisan systems:crawl_match_all
php artisan systems:crawl_match_info
php artisan systems:crawl_match_update
php artisan systems:crawl_match_result