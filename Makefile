.PHONY: sail-up
sail-up:
	./vendor/bin/sail up -d

.PHONY: sail-stop
sail-stop:
	./vendor/bin/sail stop

.PHONY: phpstan-analyse
phpstan-analyse:
	vendor/bin/phpstan analyse --configuration phpstan.neon --memory-limit=-1
