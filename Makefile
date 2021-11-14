CERTS_DIR = .certs

# Docker
.PHONY: up
up: $(CERTS_DIR)
	@docker compose up -d

.PHONY: build
build:
	@docker compose build

.PHONY: stop
stop:
	@docker-compose stop

.PHONY: down
down:
	@docker-compose down --remove-orphans --volumes

.PHONY: ssh
ssh:
	@docker-compose exec app /bin/bash

$(CERTS_DIR):
	$(MAKE) certs

.PHONY: certs
certs:
	@mkdir -p $(CERTS_DIR)
	@mkcert -install
	@mkcert -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost
