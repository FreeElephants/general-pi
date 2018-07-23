docker-build:
	docker build  -t free-elephants/general-dev .

composer-install:
	./tools/composer install

phpunit:
	./tools/phpunit

