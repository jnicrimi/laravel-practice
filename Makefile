.PHONY: sail-up
sail-up:
	./vendor/bin/sail up -d

.PHONY: sail-stop
sail-stop:
	./vendor/bin/sail stop

.PHONY: phpstan-analyse
phpstan-analyse:
	vendor/bin/phpstan analyse --configuration phpstan.neon --memory-limit=-1

.PHONY: cs
cs:
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: cs-fix
cs-fix:
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix
