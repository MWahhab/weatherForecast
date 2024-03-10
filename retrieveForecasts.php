<?php

require ("database/config.php");

/**
 * @var database\Database  $connection
 * @var ForecastController $controller
 */
$forecasts = $controller->retrieveForecasts();

if($controller->isTimeToFetch() || empty($forecasts)) {
    include ("weatherFetch.php");
    $forecasts = $controller->retrieveForecasts();
}

echo json_encode($forecasts);