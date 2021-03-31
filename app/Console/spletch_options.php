<?php

if (isset($options['h'])) {
    echo "Help...\n";
    
    printHelp($ParseSpectra->spnames);
    exit();
}

if (isset($options['s'])) {
    $ParseSpectra->setSpectraSet($options['s']);
} else
    $ParseSpectra->setSpectraSet('all');

if (isset($options['a'])) {
    $runmosaic = True;
} else
    $runmosaic = False;


if (isset($options['t']))
    $ParseSpectra->setExtraSelect($options['t']);


if (isset($options['o'])) {
    $ParseSpectra->setIds($options['o']);
} elseif (isset($options['o']) and $options['o'] == 'all') {
    $ParseSpectra->setIds('all');
} else
    die("You must specify object(s) with -o flag (eg. -o543 for id 543, -o\"543,324,123\" for id's 543, 324 and 123 or -oall for all)...\n Use -h for help...\n");

if (isset($options['w'])) {
    $ParseSpectra->setOverwright();
}

function printHelp($avsurv) {
    echo "Options are:\n";
    echo "-s (multiple integers divided by coma, all for all) : choose survey from:\n";
    print_r($avsurv);
    echo "-t (single string, must be quoted!!) : extra SQL string i.e. WHERE 'your string'....\n";
    echo "-o (multiple integers divided by coma, all for all) : choose object's id...\n";
    echo "-w (no value) : overwright ...\n";
    echo "-a (no value) : run spectra db filler and stop after finished....\n";
    return TRUE;
}

?>
