.PHONY: all install uninstall help

## Build the app
all:
	@docker-compose up -d
	@docker-compose run --rm app sh -c "composer install"
	@docker-compose run --rm app sh -c "bin/console doctrine:migrations:migrate --no-interaction"
	@docker-compose run --rm --entrypoint '' node sh -c "yarn install"

## Install the app
install:
	@docker-compose up -d

## Stop and remove docker services
uninstall:
	@docker-compose down --volumes --rmi all

## ¯\_(ツ)_/¯
help:
	@printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	@printf " make [target] [arg=\"val\"...]\n\n"
	@printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	@awk '/^[a-zA-Z\-\_0-9\@]+:/ { \
		helpLine = match(lastLine, /^## (.*)/); \
		helpCommand = substr($$1, 0, index($$1, ":")); \
		helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
		printf " ${COLOR_INFO}%-24s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)
