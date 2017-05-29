#!/bin/bash

# This script should be executed with root rights
test -w /root;
if [ ! "$?" -eq "0" ]; then
	echo "Only root can execute this script."
	exit 0
fi


WWWUSER=$1

if [ "$WWWUSER" == "" ]; then
    echo "Error: group name is missing"
    exit 0
fi

source $(dirname $0)/scripts.config.sh


# security...
if [ "$DIR_JELIX_SITES" == "" ]; then
    echo "Error: DIR_JELIX_SITES is not set in the configuration"
    exit 0
fi

#------- portail

chown -R :$WWWUSER $DIR_JELIX_SITES/portail/var/log $DIR_JELIX_SITES/www/cache $DIR_JELIX_SITES/www/data $DIR_JELIX_SITES/www/conf/users.auth.php
chmod -R g+w  $DIR_JELIX_SITES/portail/var/log $DIR_JELIX_SITES/www/cache $DIR_JELIX_SITES/www/data $DIR_JELIX_SITES/www/conf/users.auth.php

chown -R :$WWWUSER  $DIR_JELIX_SITES/temp/portail $DIR_JELIX_SITES/temp/portail-cli
chmod -R g+w  $DIR_JELIX_SITES/temp/portail $DIR_JELIX_SITES/temp/portail-cli


