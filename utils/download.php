<?php

include "_common.php";

if ($argc !== 3) {
    $name = $argv[0];
    die("Usage: $name VERSION DEST\n");
}

$VERSION = $argv[1];
$DEST = $argv[2];

echo "=> Creating directory \n";
if (!@file_exists($DEST)) {
    if (!@mkdir($DEST)) {
        die("failed to make directory $DEST\n");
    }
}

if (!@is_dir($DEST)) {
    die("$DEST exists and is not a directory\n");
}


echo "=> Downloading ContentEntity.php\n";
$contentEntityURL = get_download_url($VERSION);

$original = "";
$code = download_file($contentEntityURL, $original);
if ($code !== 200 || $original === false) {
    die("failed to download from $contentEntityURL: return code $code\n");
}

echo "=> Writing files\n";

$store = @file_put_contents("$DEST/ContentEntity.php", $original);
if ($store === false) {
    die("failed to write $DEST/ContentEntity.php\n");
}

$store = @file_put_contents("$DEST/VERSION", $VERSION . "\n");
if ($store === false) {
    die("failed to write version\n");
}

echo "Done\n";