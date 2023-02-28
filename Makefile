.PHONY: sail-up
sail-up:
	./vendor/bin/sail up -d

.PHONY: sail-stop
sail-stop:
	./vendor/bin/sail stop

.PHONY: sail-shell
sail-shell:
	./vendor/bin/sail shell

.PHONY: sail-mysql
sail-mysql:
	./vendor/bin/sail mysql

.PHONY: sail-test
sail-test:
	./vendor/bin/sail test

.PHONY: phpstan
phpstan:
	vendor/bin/phpstan analyse --configuration phpstan.neon --memory-limit=-1

.PHONY: cs
cs:
	PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: cs-fix
cs-fix:
	PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer/vendor/bin/php-cs-fixer fix

.PHONY: clear-cache
clear-cache:
	vendor/bin/envoy run clear-cache
