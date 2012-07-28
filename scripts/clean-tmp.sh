#!/bin/bash


# This script should be executed with root rights
#test -w /root;
#if [ ! "$?" -eq "0" ]; then
#	echo "Only root can execute this script."
#	exit 0
#fi

source $(dirname $0)/scripts.config.sh

# security...
if [ "$DIR_JELIX_SITES" == "" ]; then
    echo "Error: DIR_JELIX_SITES is not set in the configuration"
    exit 0
fi

rm -rf $DIR_JELIX_SITES/temp/portail/*

rm -rf $DIR_JELIX_SITES/temp/portail-cli/*

rm -rf $DIR_JELIX_SITES/temp/portail-scripts/*
