SHELL := /bin/bash

## —— Symfony 🎶 ———————————————————————————————————————————————————————————————
start:	## Vider le cache
	symfony server:start -d

cc:	## Vider le cache
	$(SYMFONY_CONSOLE) cache:clear

phpcbf:
	php vendor/bin/phpcbf

phpcs:
	php vendor/bin/phpcs

quality-assurance-static-analyse:
	php vendor/bin/phpstan analyse src/

tests:
	php bin/console doctrine:database:drop --force --env=test || true
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update -f --env=test
	php bin/console doctrine:fixtures:load -n --env=test
	vendor\bin\phpunit
.PHONY: tests