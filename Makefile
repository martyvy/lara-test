rebuild:
	docker-compose up --build --force-recreate --no-deps -d
test:
	php artisan test
n_e:
	php artisan notification:push email reminder [1,2,3]
n_s:
	php artisan notification:push sms reminder [1,2,3]
ll:
	echo "" > storage/logs/laravel.log
