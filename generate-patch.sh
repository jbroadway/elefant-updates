#!/bin/bash
#
# Prepares the publishing of an update to the Elefant CMS project
# for a new release that has been tagged.

if [ "$#" -ne 2 ]
then
	echo "Usage: ./generate-patch.sh 2.0.8 2.0.9"
	exit 1
fi

PREV="$1"
PREV_UND="${PREV//./_}"
VERSION="$2"
VERSION_UND="${VERSION//./_}"

cd ~/projects/elefant

if [[ ! `grep "$VERSION" www/conf/version.php` ]]
then
	echo "Error: Version $VERSION doesn't match version in ~/projects/elefant/www/conf/version.php"
	cat www/conf/version.php
	exit 1
fi

cd releases

echo "Cloning into ~/projects/elefant/releases/elefant-elefant_${VERSION_UND}_stable"
echo ""
git clone --depth=1 --branch=master https://github.com/jbroadway/elefant.git elefant-elefant_"$VERSION_UND"_stable
rm -Rf elefant-elefant_"$VERSION_UND"_stable/.git

echo ""
echo "Creating patch"
diff -urBNs elefant-elefant_"$PREV_UND"_stable elefant-elefant_"$VERSION_UND"_stable > elefant-"$PREV"-"$VERSION".patch
mv elefant-"$PREV"-"$VERSION".patch ../updates/patches/

echo ""
echo "Running php scripts/patches.php"
cd ~/projects/elefant/updates/
php scripts/patches.php

echo ""
echo "Testing patch with --dry-run"
echo ""
cd ~/projects/elefant/releases/elefant-elefant_"$PREV_UND"_stable/
patch --dry-run -p1 -f -i ~/projects/elefant/updates/patches/elefant-"$PREV"-"$VERSION".patch

echo ""
echo "Next steps:"
echo ""
echo "1. Edit the appropriate ~/projects/elefant/updates/releases/*.json"
echo "2. Run: php scripts/callbacks.php"
echo "3. Run: php scripts/checksums.php"
echo "4. Commit & push changes in ~/projects/elefant/checksums/"
echo "5. Commit & push changes in ~/projects/elefant/updates/"
echo ""
