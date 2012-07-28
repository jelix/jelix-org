#!/bin/bash

# backup script called by a master backup scripts (not in this repository)
# arguments :
#  - target directory for backup
#  - arguments for mysql

BACKUP_DIR=$1
MYSQL_ARGS=$2

ROOTDIR=$(dirname $0)/..

#if [ ! -d $BACKUP_DIR/download ]; then 
#  mkdir $BACKUP_DIR/download
#fi

if [ -d $BACKUP_DIR/portal ]; then 
  rm -rf $BACKUP_DIR/portal/*
else
  mkdir $BACKUP_DIR/portal
fi

cd $ROOTDIR

echo "backup miscellaneous files..."
# better to backup directly from the admin host with rsync
#rsync -a download/www/* $BACKUP_DIR/download/
cp -a lib/dokuwiki/conf/users.auth.php $BACKUP_DIR/portal/

echo "backup dokuwiki files..."
tar czf $BACKUP_DIR/portal/dokuwiki_data.tar.gz --exclude=.hg www/data/

DUMP_DATA_OPTIONS="--complete-insert --default-character-set=utf8  --extended-insert --no-create-db --no-create-info --single-transaction --quote-names"
DUMP_SCHEMA_OPTIONS="--add-drop-table --create-options --no-data --single-transaction --quote-names"

DBLIST="jelix_www"

for dbname in $DBLIST; do
    echo "Dump $dbname..."
    mysqldump $MYSQL_ARGS $DUMP_DATA_OPTIONS $dbname   > $BACKUP_DIR/portal/"$dbname"_data.sql
    mysqldump $MYSQL_ARGS $DUMP_SCHEMA_OPTIONS $dbname > $BACKUP_DIR/portal/"$dbname"_schema.sql
done

cd -

