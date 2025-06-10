<?php

include "_common.php";

if ($argc !== 2) {
    $name = $argv[0];
    die("Usage: $name DIRECTORY\n");
}

$DEST = $argv[1];

echo "=> Reading version";
$VERSION = @file_get_contents("$DEST/VERSION");
if ($VERSION === false) {
    die("Failed to read VERSION file\n");
}

$VERSION = trim($VERSION);
echo "$VERSION\n";

echo "=> Downloading original ContentEntity.php\n";

$contentEntityURL = get_download_url($VERSION);

$original = "";
$code = download_file($contentEntityURL, $original);
if ($code !== 200 || $original === false) {
    die("failed to download from $contentEntityURL: return code $code\n");
}

echo "=> Reading local ContentEntity.php\n";

$patched = file_get_contents("$DEST/ContentEntity.php");
if ($patched === false) {
    die("Failed to read local file\n");
}

echo "=> Creating diff\n";
$diff = make_diff($original, $patched);
if ($diff === false) {
    die("Failed to create diff\n"); 
}


echo "=> Writing ContentEntity.php.diff\n";
$store = @file_put_contents("$DEST/ContentEntity.php.diff", $diff);
if ($store === false) {
    die("failed to write $DEST/ContentEntity.php.diff\n");
}

echo "Done\n";