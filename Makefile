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

.PHONY: phpstan-analyse
phpstan-analyse:
	vendor/bin/phpstan analyse --configuration phpstan.neon --memory-limit=-1

.PHONY: cs
cs:
	PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: cs-fix
cs-fix:
	PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer/vendor/bin/php-cs-fixer fix
