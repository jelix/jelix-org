
ifndef JELIX_ORG_DB_NAME
    JELIX_ORG_DB_NAME=jelix_www
endif
ifndef JELIX_ORG_DB_HOST
    JELIX_ORG_DB_HOST=127.0.0.1
endif
ifndef JELIX_ORG_DB_LOGIN
    JELIX_ORG_DB_LOGIN=jelix
endif
ifndef JELIX_ORG_DB_PASSWD
    JELIX_ORG_DB_PASSWD=jelix
endif
ifndef JELIX_ORG_BUILD_DIR
    JELIX_ORG_BUILD_DIR='$DIR_JELIX_SITES/temp/build_dir'
endif
ifndef JELIX_ORG_RECAPTCHA_KEY
    JELIX_ORG_RECAPTCHA_KEY=
endif
ifndef JELIX_ORG_RECAPTCHA_SECRET
    JELIX_ORG_RECAPTCHA_SECRET=
endif
ifndef JELIX_ORG_DEPLOY_TARGET
    JELIX_ORG_DEPLOY_TARGET=/tmp/jelix.org
endif


portail/var/config/defaultconfig.ini.php:
	cp portail/var/config/defaultconfig.ini.php.dist portail/var/config/defaultconfig.ini.php
	@sed -i "s!__JELIX_ORG_RECAPTCHA_KEY__!$(JELIX_ORG_RECAPTCHA_KEY)!" portail/var/config/defaultconfig.ini.php
	@sed -i "s!__JELIX_ORG_RECAPTCHA_SECRET__!$(JELIX_ORG_RECAPTCHA_SECRET)!" portail/var/config/defaultconfig.ini.php


portail/var/config/dbprofils.ini.php:
	cp portail/var/config/dbprofils.ini.php.dist portail/var/config/dbprofils.ini.php
	@sed -i "s!__JELIX_ORG_DB_NAME__!$(JELIX_ORG_DB_NAME)!" portail/var/config/dbprofils.ini.php
	@sed -i "s!__JELIX_ORG_DB_HOST__!$(JELIX_ORG_DB_HOST)!" portail/var/config/dbprofils.ini.php
	@sed -i "s!__JELIX_ORG_DB_LOGIN__!$(JELIX_ORG_DB_LOGIN)!" portail/var/config/dbprofils.ini.php
	@sed -i "s!__JELIX_ORG_DB_PASSWD__!$(JELIX_ORG_DB_PASSWD)!" portail/var/config/dbprofils.ini.php

scripts/scripts.config.sh:
	cp scripts/scripts.config.sh.dist scripts/scripts.config.sh
	@sed -i "s!__JELIX_ORG_BUILD_DIR__!$(JELIX_ORG_BUILD_DIR)!" scripts/scripts.config.sh

.PHONY: build
build: clean _build

.PHONY: _build
_build: portail/var/config/defaultconfig.ini.php portail/var/config/dbprofils.ini.php scripts/scripts.config.sh
	composer install --prefer-dist --no-dev --no-progress --no-suggest --ignore-platform-reqs --no-ansi --no-interaction --working-dir=scripts/

.PHONY: clean
clean:
	rm -f portail/var/config/defaultconfig.ini.php portail/var/config/dbprofils.ini.php scripts/scripts.config.sh

.PHONY: deploy
deploy: build
	rsync -av --delete --ignore-times --checksum --include-from=.build-files ./ $(JELIX_ORG_DEPLOY_TARGET)


