#!/bin/bash

. ./install/scripts.config.sh


# arguments :
#  - target directory for backup

BACKUP_DIR=$1

cd $ROOTDIR


if [ -f $BACKUP_DIR/users.auth.php ]
then
    echo "Restore users.auth.php for dokuwiki"
    cp -a $BACKUP_DIR/users.auth.php lib/dokuwiki/conf/
else
    echo "users.auth.php for dokuwiki is missing"
fi


if [ -f $BACKUP_DIR/dokuwiki_data.tar.gz ]
then
    echo "Restore dokuwiki data (dokuwiki_data.tar.gz)"
    tar xzf $BACKUP_DIR/dokuwiki_data.tar.gz
else
    echo "dokuwiki_data.tar.gz is missing"
fi

echo "Enter mysql user"
read -s MYSQL_ADMIN_USER
echo "Enter the password for the mysql user $MYSQL_ADMIN_USER"
read -s MYSQL_PASSWORD

OPTIONS=" --default-character-set=utf8"
DBLIST="jelix_www"

for dbname in $DBLIST; do
    echo "restore database $dbname..."
    mysql -u $MYSQL_ADMIN_USER -p$MYSQL_PASSWORD $OPTIONS $dbname < $BACKUP_DIR/"$dbname"_schema.sql
    mysql -u $MYSQL_ADMIN_USER -p$MYSQL_PASSWORD $OPTIONS $dbname < $BACKUP_DIR/"$dbname"_data.sql
done

