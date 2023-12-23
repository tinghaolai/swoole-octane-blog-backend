ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

serve:
	@echo "Starting the octane server..."
	@./vendor/bin/sail artisan octane:start --watch --host 0.0.0.0

build-images:
	@echo "Building images..."
	@./vendor/bin/sail build

composer-build:
	@echo "Installing php dependencies..."
	@docker run --rm \
		-v "$(ROOT_DIR):/var/www/html" \
		-w /var/www/html \
		laravelsail/php81-composer:latest \
		composer install --ignore-platform-reqs

npm-build:
	@echo "Installing npm dependencies..."
	@./vendor/bin/sail npm install

build: composer-build build-images

install:
	@echo "Installing dependencies..."
	@./vendor/bin/sail composer install

code-quality:
	@echo "Running code quality tools..."
	@./vendor/bin/sail artisan test
	@./vendor/bin/sail pint --test

code-beautify:
	@echo "Running code beautify tools..."
	@./vendor/bin/sail pint

help:
	@sed \
		-e '/^[a-zA-Z0-9_\-]*:.*##/!d' \
		-e 's/:.*##\s*/:/' \
		-e 's/^\(.\+\):\(.*\)/$(shell tput setaf 6)\1$(shell tput sgr0):\2/' \
		$(MAKEFILE_LIST) | sort | column -c2 -t -s :
