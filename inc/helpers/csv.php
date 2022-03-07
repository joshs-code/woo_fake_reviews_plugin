<?php

function csvToArray($csvFile)
{
    $csv = array_map('str_getcsv', file($csvFile));
    array_walk($csv, function (&$a) use ($csv) {
        $a = array_combine($csv[0], $a);
    });
    array_shift($csv); # remove column header
    return $csv;
}
