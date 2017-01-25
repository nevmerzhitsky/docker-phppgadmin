<?php

    ini_set("display_errors", 1);

    // Include application functions
    include_once('./libraries/lib.inc.php');
    include_once('./classes/Graph.php');

    global $conf, $lang;

    $graph = new Graph($misc, $data);
    if (!$graph->isAvailable()) {
        die("GraphViz is not available.");
    }
    
    $graph->dumpImage($_REQUEST['schema'], $_REQUEST['table']);
?>
