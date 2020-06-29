# Elefant Updates

This repository contains update files (patches and scripts) for the
[Elefant CMS](http://www.elefantcms.com/). It is used by the CMS to
check for, fetch, and apply new updates.

The Elefant admin toolbar will check the raw URLs in this repository
looking for the following form:

	https://raw.github.com/jbroadway/elefant-updates/master/releases/1.3.json

This file contains the latest release available for that series in the form:

	{"latest": "1.3.6"}

This can also be called via JSONP like this:

	https://raw.github.com/jbroadway/elefant-updates/master/releases/1.3.js?callback=elefant_release_update

This will return the same result in the form:

	elefant_release_update({"latest": "1.3.6"})

If a new version is available (compared to the site's current version),
Elefant can then request a list of all available scripts and patches
like this:

	https://raw.github.com/jbroadway/elefant-updates/master/patches.json

This will contain the following data structure:

	{
		"patches": [
			"https:\/\/raw.github.com\/jbroadway\/elefant-updates\/master\/patches\/elefant-1.3.4-1.3.5.patch",
			"https:\/\/raw.github.com\/jbroadway\/elefant-updates\/master\/patches\/elefant-1.3.5-1.3.6.patch"
		],
		"scripts": [
		]
	}

## How to update for new releases

First, make sure you've updated `conf/version.php` and `composer.json` and pushed the
changes to GitHub.

Next, tag the release on GitHub under Releases with a writeup of the changes.

Now you can generate a patch file via the following:

	./generate-patch.sh 2.0.8 2.0.9

This will fetch a copy of the latest source code from the master branch and generate
a patch file against the previous release's folder as follows:

	diff -urBNs elefant-v1 elefant-v2 > elefant-v1-v2.patch

Then it will move this file into the `patches` folder and run the following to generate
an updated `patches.json`:

	php scripts/patches.php

The next steps are all described in the output of `./generate-patch.sh`.

Edit the appropriate `releases/*.json` files with the latest version number.
The `.js` files for the JSONP support can then be created via:

	php scripts/callbacks.php

Finally, create the checksums for the updater to verify the authenticity of the
update files. This assumes that the [elefantcms/checksums](https://github.com/elefantcms/checksums)
repository was cloned into a folder beside the `jbroadway/elefant-updates` folder.

	php scripts/checksums.php

The regenerated files can now be committed and pushed to the two respective Github
repositories.

## How to test a patch

To test a patch, run this in the root folder of a site running the previous release:

	patch --dry-run -p1 -f -i ~/projects/updates/patches/file.patch
