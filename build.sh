#!/bin/bash

BASEPATH="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BINPATH="$BASEPATH/bin"
DISTPATH="$BASEPATH/dist"
FILENAME="syntaxhighlighter3"
FILEPATH="$DISTPATH/$FILENAME.tar.gz"
BUILDPATH="$BINPATH/$FILENAME"

if [ ! -d "$BASEPATH/$FILENAME" ]; then
    echo 'ERROR: syntaxhighlighter3 folder not found...'
    exit 1
fi

# create bin path and dist path
rm -rf "$BINPATH"
mkdir -p "$BINPATH"
if [ ! -d "$DISTPATH" ]; then mkdir -p "$DISTPATH"; fi

# copy plugin folder
cp -avr "$BASEPATH/$FILENAME" "$BINPATH"

# copy others files
cp "$BASEPATH/CHANGELOG.md" "$BUILDPATH"
cp "$BASEPATH/LICENSE" "$BUILDPATH"
cp "$BASEPATH/README.md" "$BUILDPATH"

# create archive
rm -f "$FILEPATH"
tar -zcvf "$FILEPATH" -C "$BINPATH" $FILENAME
