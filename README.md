# WissKI Search Patches

This folder contains patches for various versions of Drupal's [search_api](https://www.drupal.org/project/search_api) module to work with [WissKI](https://wiss-ki.eu/documentation/search/solr-search).

Each version of `search_api` is found in its' own directory.

Fully tested versions are:

- 8.x-1.30

Will probably work:

- 8.x-1.31
- 8.x-1.32
- 8.x-1.33
- 8.x-1.34
- 8.x-1.35

Untested:

- 8.x-1.36
- 8.x-1.37
- 8.x-1.38

## Creating a new version patch

- The file `download.php` downloads the original `ContentEntity.php` file and places it into a new directory to patch a new version.
- The file `patch.php` creates a patch from a modified `ContentEntity.php` file.

To manually create a patch it would be something like the following:

```bash
OLD_VERSION="8.x-1.38"
NEW_VERSION="8.x-1.whatever"

# download the new patch file into an appropriate directory
php utils/download.php $NEW_VERSION $NEW_VERSION 

# try to apply the old version's patch. 
# this may fail - if so please patch manually. 
patch $NEW_VERSION/ContentEntity.php <$OLD_VERSION/ContentEntity.php.diff

# check that the patch is correct
$EDITOR $NEW_VERSION/ContentEntity.php 

# and finally create a new .diff
php utils/patch.php $NEW_VERSION

# update this README file
$EDITOR README.md
```