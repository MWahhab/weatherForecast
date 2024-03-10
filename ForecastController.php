<?php

namespace weatherForecast;
use database;
use Forecast;

class ForecastController
{
    /**
     * @var \database\Database $connection Refers to the database connection
     */
    private database\Database $connection;

    /**
     * @param \database\Database $connection Refers to the database connection
     *
     * Upon instantiation, sets the database connection property
     */
    public function __construct(database\Database $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array Retrieves all the forecasted data stored in the database
     */
    public function retrieveForecasts(): array
    {
        return $this->connection->select("forecast");
    }

    /**
     * @param array $forecasts Array of forecast instantiations
     * @return bool             Attempts to add forecasts to the db
     */
    public function addForecasts(array $forecasts): bool
    {
        if (empty($forecasts) || count($forecasts) < 7) {
            echo "Insufficient amount of forecast days/data provided. Cannot add to db";
            return false;
        }

        $this->connection->createTable(
            "forecast",
            [
                "id" => "INT AUTO_INCREMENT PRIMARY KEY",
                "date" => "VARCHAR(255)",
                "day" => "VARCHAR(255)",
                "weather" => "VARCHAR(255)",
                "temperature" => "FLOAT(5,2)",
            ]
        );

        $insert = [];

        /**
         * @var Forecast $forecast
         */
        foreach ($forecasts as $forecast) {
            $forecastArr = [
                "date" => $forecast->getDate(),
                "day" => $forecast->getDay(),
                "temperature" => $forecast->getTemperature(),
                "weather" => $forecast->getWeather()
            ];

            $insert[] = $forecastArr;
        }

        $this->connection->truncateTable("forecast");

        return $this->connection->insertMultiple(
            "forecast",
            $insert
        );
    }

    /**
     * @return bool Checks whether it's time to fetch from the api based on the current date
     */
    public function isTimeToFetch(): bool
    {
        $lastDatePath = "C:\\xampp\htdocs\\weatherForecast\last_date.txt";
        $currentDate = date("Y-m-d");

        if (file_exists($lastDatePath)) {
            $lastDate = file_get_contents($lastDatePath);
            file_put_contents($lastDatePath, $currentDate);

            return $lastDate !== $currentDate;
        }

        file_put_contents($lastDatePath, $currentDate);
        return true;
    }

}