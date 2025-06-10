# WissKI Search Patches

This folder contains patches for various versions of Drupal's [search_api](https://www.drupal.org/project/search_api) module to work with [WissKI](https://wiss-ki.eu/documentation/search/solr-search).

Each version of `search_api` is found in it's own directory.

## Utility scripts

- The file `download.php` downloads the original `ContentEntity.php` file and places it into a new directory to patch a new version.
- The file `patch.php` creates a patch from a modified `ContentEntity.php` file.