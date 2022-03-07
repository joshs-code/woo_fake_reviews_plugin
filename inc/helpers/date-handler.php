<?php

function randDate($latestDate)
{
    $date = date_create($latestDate);
    $min = date_format($date, 'Y-m-d H:i:s');
    $max = date('Y-m-d H:i:s');

    $latestDate = strtotime($min);
    $today = strtotime($max);

    $randDate = rand($today, $latestDate);
    $randDate = date('Y-m-d H:i:s', $randDate);
    return $randDate;
}
