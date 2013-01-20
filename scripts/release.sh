#!/bin/bash

SCRIPTDIR=$(dirname $0)
source $SCRIPTDIR/scripts.config.sh

VERSION=$1
if [ "$VERSION" == "" ]; then
    echo "Error: version is missing"
    exit 1
fi

NEXTVERSION=$2
if [ "$NEXTVERSION" == "" ]; then
    echo "Warning: next version is missing. Roadmap in trac will not be updated."
fi


VER_MAJOR=""
VER_MIDDLE=""
VER_MINOR=""
VER_FIX=""

for i in $(echo $VERSION | tr "." "\n")
do
    if [ "$VER_MAJOR" == "" ]
    then
        VER_MAJOR=$i
    else
        if [ "$VER_MIDDLE" == "" ]
        then
            VER_MIDDLE=$i
        else
            if [ "$VER_MINOR" == "" ]
            then
                VER_MINOR=$i
            else
                if [ "$VER_FIX" == "" ]
                then
                    VER_FIX=$i
                else
                    echo "Too much version separators"
                    exit 1
                fi
            fi
        fi
    fi
  # process
done

if [ "$VER_MAJOR" == "" ]
then
    echo "Error: bad version number?"
    exit 1
fi

if [ "$VER_MIDDLE" == "" ]
then
    VER_MIDDLE="0"
fi
if [ "$VER_MINOR" == "" ]
then
    VER_MINOR="0"
fi


BRANCH_VERSION="$VER_MAJOR.$VER_MIDDLE.x"
if [ "$VER_FIX" == "" ]
then
    TAG_NAME="RELEASE_JELIX_${VER_MAJOR}_${VER_MIDDLE}_${VER_MINOR}"
else
    TAG_NAME="RELEASE_JELIX_${VER_MAJOR}_${VER_MIDDLE}_${VER_MINOR}_${VER_FIX}"
fi

MANUAL_FR="manuel-${VER_MAJOR}.${VER_MIDDLE}"
MANUAL_EN="manual-${VER_MAJOR}.${VER_MIDDLE}"

echo "VER_MAJOR=$VER_MAJOR"
echo "VER_MIDDLE=$VER_MIDDLE"
echo "VER_MINOR=$VER_MINOR"
echo "BRANCH_VERSION=$BRANCH_VERSION"
echo "TAG_NAME=$TAG_NAME"
echo "MANUAL_FR=$MANUAL_FR"
echo "MANUAL_EN=$MANUAL_EN"

$SCRIPTDIR/build_release_pack $BRANCH_VERSION $TAG_NAME $VERSION
$SCRIPTDIR/build_release_doc $BRANCH_VERSION $TAG_NAME $VERSION

$DIR_JELIX_SITES/../docs.jelix.org/update_repo_and_books.sh --force $MANUAL_FR
$DIR_JELIX_SITES/../docs.jelix.org/update_repo_and_books.sh --force $MANUAL_EN

echo "move manual to download.jelix.org"
mv $DIR_JELIX_SITES/../docs.jelix.org/books/pdf/en/jelix-$MANUAL_EN.pdf $SCRIPTDIR/../download/www/jelix/releases/${VER_MAJOR}.${VER_MIDDLE}.x/$VERSION/jelix-manual-$VERSION.pdf
mv $DIR_JELIX_SITES/../docs.jelix.org/books/pdf/fr/jelix-$MANUAL_FR.pdf $SCRIPTDIR/../download/www/jelix/releases/${VER_MAJOR}.${VER_MIDDLE}.x/$VERSION/jelix-manuel-$VERSION.pdf

echo "write version into the latest-stable-version file"
API_DIR="$SCRIPTDIR/../www/api/releases/${VER_MAJOR}.${VER_MIDDLE}"
if [ ! -d $API_DIR ]
then
    mkdir $API_DIR
fi
echo $VERSION > "$API_DIR/latest-stable-version"

echo "clear wiki cache"

rm -rf $DIR_JELIX_SITES/www/data/cache/*

if [ "$NEXTVERSION" != "" ]; then
    echo "Trac: close milestone and create a new one"
    php $DIR_JELIX_SITES/portail/scripts/portal.php main~trac:closeroadmap $VERSION $NEXTVERSION
fi
echo ""
echo "End of the release!"
echo ""

