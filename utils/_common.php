<?php

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    die("must be included, not executed directory\n");
}

if((php_sapi_name() !== 'cli')) {
    die("must be run from command line\n");
}

function get_download_url(string $version): string {
    return "https://git.drupalcode.org/project/search_api/-/raw/$version/src/Plugin/search_api/datasource/ContentEntity.php?ref_type=tags&inline=false";
}

function download_file(string $url, string &$dest): int {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "curl/8.7.1");
   
    $dest = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $code;
}


function make_diff(string $old, string $new): string|false {
    $old_temp = tempnam(sys_get_temp_dir(), "diff");
    if ($old_temp === false) {
        throw new Exception("failed to create temporary file");
    }
    $new_temp = tempnam(sys_get_temp_dir(), "diff");
    if ($new_temp === false) {
        throw new Exception("failed to create temporary file");
    }

    try {
        if (file_put_contents($old_temp, $old) === false) {
            throw new Exception("failed to write to temporary file $old_temp");
        }
        if (file_put_contents($new_temp, $new) === false) {
            throw new Exception("failed to write to temporary file $new_temp");
        }

        $diff = shell_exec("diff " . escapeshellarg($old_temp) . " " . escapeshellarg($new_temp));
        if (!is_string($diff)) {
            throw new Exception("Failed to execute diff command");
        }

        return $diff;
    } catch (Exception $e) {
        return false;
    } finally {
        if (file_exists($old_temp)) {
            unlink($old_temp);
        }
        if (file_exists($new_temp)) {
            unlink($new_temp);
        }
    }
}