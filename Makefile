.PHONY: install ci phplint phpstan code-checker coding-standards tester

install:
	composer update

ci: phplint phpstan code-checker coding-standards tester

phplint:
	composer phplint

phpstan:
	composer phpstan

code-checker:
	composer code-checker

coding-standards:
	composer coding-standards

tester:
	composer tester
