<?php

    // Prevent timeouts on large exports (non-safe mode only)
    if (!ini_get('safe_mode')) set_time_limit(0);

    // Include application functions
    include_once('./libraries/lib.inc.php');

    global $conf, $lang;


    if (is_array($_REQUEST['key']))
        $key = $_REQUEST['key'];
    else
        $key = unserialize($_REQUEST['key']);

    $rs = $data->browseRow($_REQUEST['table'], $key);

    // Dump bytea if needed.
    if (!$rs->fields) {
        die("No result.");
    }
    
    $field = $_REQUEST['field'];
    $bytea = $rs->fields[$field];
    
    $tmp = tempnam(sys_get_temp_dir(), "bytea_");
    file_put_contents($tmp, $bytea);
    $isz = @getimagesize($tmp);
    unlink($tmp);
    if ($isz && $isz['mime']) {
        header("Content-Type: {$isz['mime']}");
    } else {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$field.dat\"");
    }
    echo $bytea;
