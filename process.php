#!/usr/bin/php
<?php

require 'postcodes.php';
require 'config.php';

declare(ticks = 1);

pcntl_signal(SIGINT, function() {
    global $results;
    echo "\n\n";
    echo json_encode($results, JSON_PRETTY_PRINT);
    echo "\n\n";
    die;
});

$results = [];
$api_key = 0;
$i = 0;

while ($i < count($postcodes)) {
    $key = $google_api_keys[$api_key];
    plog("Using key: {$key}");
    plog("Grabbing lat/long for {$postcodes[$i]}");
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' .
                $key . '&address=' . urlencode($postcodes[$i]);    
    $data = file_get_contents($url);
    $data = json_decode($data);
    
    if ($data->status == 'OVER_QUERY_LIMIT') {
        if ($api_key == count($google_api_keys)) {
            plog("Out of API keys");
            $i = count($postcodes);
        }
        $api_key++;
    } else {
        $latlng = $data->results[0]->geometry->location;
        array_push($results, [
            'postcode' => $postcodes[$i],
            'lat' => $latlng->lat,
            'lon' => $latlng->lng
        ]);
        
        $i++;
    }
}
echo "\n\n";
echo json_encode($results, JSON_PRETTY_PRINT);
echo "\n\n";

function plog($msg) {
    $date = date('H:i:s');
    echo "[{$date}] {$msg}\n";
}
