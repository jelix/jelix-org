#!/bin/bash
set -e

# script called by the CI tool each time a push is made
# the current dir is a git source dir.

DIR_JELIX_SITES=$(dirname $0)/../..

BRANCH="$1"
if [ "$BRANCH" == "" ]; then
    BRANCH=`git rev-parse --abbrev-ref HEAD`
fi

BUILD_GOLD="N"
BUILD_FONT_PACKAGE="N"
HASMODULES="Y"

case $BRANCH in
    jelix-1.3.x)
        BRANCHVERSION="1.3.x"
        HASMODULES="N"
        BUILD_GOLD="Y"
        BUILD_FONT_PACKAGE="Y"
    ;;
    jelix-1.4.x)
        BRANCHVERSION="1.4.x"
        HASMODULES="N"
        BUILD_GOLD="Y"
        BUILD_FONT_PACKAGE="Y"
    ;;
    jelix-1.5.x)
        BRANCHVERSION="1.5.x"
        BUILD_GOLD="Y"
    ;;
    jelix-1.6.x)
        BRANCHVERSION="1.6.x"
    ;;
    jelix-1.7.x)
        BRANCHVERSION="1.7.x"
    ;;
    master)
        BRANCHVERSION="2.0.x"
    ;;
    *)
    echo "Error: branch name is missing or wrong ('$BRANCH')"
    exit 1
esac
FILENAME="jelix-$BRANCHVERSION"
TESTAPPFILENAME="testapp-$BRANCHVERSION"
FONTSFILENAME="jelix-$BRANCHVERSION-pdf-fonts"

DISTPATH=`pwd`"/_dist/"

echo "building $BRANCH branch..."
echo "=========================="
   
export DOWNLOADPATH=$DIR_JELIX_SITES/download/www/jelix/nightly/$BRANCHVERSION/

if [ ! -d $DOWNLOADPATH ]; then
    mkdir -p $DOWNLOADPATH
fi

make nightlies
if [ "$?" != "0" ]; then
    echo "--- error"
    exit 1
fi

mv -f "$DISTPATH"testapp-*.zip    $DOWNLOADPATH
mv -f "$DISTPATH"testapp-*.tar.gz $DOWNLOADPATH

mv -f "$DISTPATH"jelix-*.zip    $DOWNLOADPATH
mv -f "$DISTPATH"jelix-*.tar.gz $DOWNLOADPATH

if [ "$HASMODULES" == "Y" ]; then
    mv -f "$DISTPATH"module-*.zip    $DOWNLOADPATH
    mv -f "$DISTPATH"module-*.tar.gz $DOWNLOADPATH
fi

PACKAGE_NAME_DEV=`cat "$DISTPATH"PACKAGE_NAME_DEV`
PACKAGE_NAME_OPT=`cat "$DISTPATH"PACKAGE_NAME_OPT`
if [ "$BUILD_GOLD" == "Y" ]; then
    PACKAGE_NAME_GOLD=`cat "$DISTPATH"PACKAGE_NAME_GOLD`
fi
PACKAGE_TESTAPP_NAME=`cat "$DISTPATH"PACKAGE_TESTAPP_NAME`

cd $DIR_JELIX_SITES/download/www/jelix/nightly/
if  [ -f latest-nightly-$FILENAME-dev.tar.gz ]
then
    rm latest-nightly-$FILENAME-dev.tar.gz
fi
if  [ -f latest-nightly-$FILENAME-opt.tar.gz ]
then
    rm latest-nightly-$FILENAME-opt.tar.gz
fi
if  [ -f latest-nightly-$TESTAPPFILENAME.tar.gz ]
then
    rm latest-nightly-$TESTAPPFILENAME.tar.gz
fi

ln -s $BRANCHVERSION/"$PACKAGE_NAME_DEV".tar.gz latest-nightly-$FILENAME-dev.tar.gz
ln -s $BRANCHVERSION/"$PACKAGE_NAME_OPT".tar.gz latest-nightly-$FILENAME-opt.tar.gz
ln -s $BRANCHVERSION/"$PACKAGE_TESTAPP_NAME".tar.gz latest-nightly-$TESTAPPFILENAME.tar.gz
    
if  [ -f latest-nightly-$FILENAME-dev.zip ]
then
    rm latest-nightly-$FILENAME-dev.zip
fi
if  [ -f latest-nightly-$FILENAME-opt.zip ]
then
    rm latest-nightly-$FILENAME-opt.zip
fi
if  [ -f latest-nightly-$TESTAPPFILENAME.zip ]
then
    rm latest-nightly-$TESTAPPFILENAME.zip
fi
ln -s $BRANCHVERSION/"$PACKAGE_NAME_DEV".zip latest-nightly-$FILENAME-dev.zip
ln -s $BRANCHVERSION/"$PACKAGE_NAME_OPT".zip latest-nightly-$FILENAME-opt.zip
ln -s $BRANCHVERSION/"$PACKAGE_TESTAPP_NAME".zip latest-nightly-$TESTAPPFILENAME.zip

if [ "$BUILD_GOLD" == "Y" ]; then
    if  [ -f latest-nightly-$FILENAME-gold.tar.gz ]
    then
        rm latest-nightly-$FILENAME-gold.tar.gz
    fi
    ln -s $BRANCHVERSION/"$PACKAGE_NAME_GOLD".tar.gz latest-nightly-$FILENAME-gold.tar.gz
    if  [ -f latest-nightly-$FILENAME-gold.zip ]
    then
        rm latest-nightly-$FILENAME-gold.zip
    fi
    ln -s $BRANCHVERSION/"$PACKAGE_NAME_GOLD".zip latest-nightly-$FILENAME-gold.zip
fi

if [ "$BUILD_FONT_PACKAGE" == "Y" ]
then
    PACKAGE_FONTS_NAME=`cat "$DISTPATH"PACKAGE_FONTS_NAME`
    if  [ -f latest-nightly-$FONTSFILENAME.zip ]
    then
        rm latest-nightly-$FONTSFILENAME.zip
    fi
    ln -s $BRANCHVERSION/"$PACKAGE_FONTS_NAME".zip latest-nightly-$FONTSFILENAME.zip
fi

if [ "$?" != "0" ]; then
    echo "--- error"
    exit 1
fi

echo "----- end"
echo ""
