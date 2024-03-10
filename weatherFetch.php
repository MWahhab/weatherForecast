<?php

require ("database/config.php");
require ("Forecast.php");

/**
 * @var database\Database  $connection
 * @var ForecastController $controller
 */

$key  = #apiKey;
$city = "London";
$days = 7;

$link            = "https://api.weatherapi.com/v1/forecast.json?key={$key}&q={$city}&days={$days}";
$apiErrorLogPath = "C:\\xampp\htdocs\\weatherForecast\api_log.txt";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if(curl_errno($ch)) {
    file_put_contents($apiErrorLogPath, "Error: " . curl_error($ch));
}

curl_close($ch);

if(empty($response)) {
    file_put_contents($apiErrorLogPath, "Error fetching data from weather api. Response empty!", FILE_APPEND);
}

$weatherData  = json_decode($response, true);

$forecastDays = $weatherData['forecast']['forecastday'];

if(!isset($forecastDays)) {
    file_put_contents($apiErrorLogPath, "Error: Response unexpected! Doesnt contain forecast!", FILE_APPEND);
}
if(count($forecastDays) !== $days) {
    file_put_contents($apiErrorLogPath, "Error: The specified number of days wasn't retrieved!", FILE_APPEND);
}

$forecastArr  = [];

foreach ($forecastDays as $forecastDay) {
    $date        = $forecastDay["date"];
    $day         = date("l", strtotime($date));
    $temperature = $forecastDay["day"]["avgtemp_c"];
    $weather     = $forecastDay["day"]["condition"]["text"];

    $forecastArr[] = new Forecast($date, $day, $temperature, $weather);
}

if(!$controller->addForecasts($forecastArr)) {
    file_put_contents($apiErrorLogPath, "Issue with adding forecasts to db!", FILE_APPEND);
    die();
}

file_put_contents($apiErrorLogPath, "Successfully fetched from weather API!");