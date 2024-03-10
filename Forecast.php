<?php

namespace weatherForecast;
class Forecast
{
    /**
     * @var string $date Refers to the forecast date
     */
    private string $date;
    /**
     * @var string $day Refers to the forecast day
     */
    private string $day;
    /**
     * @var float $temperature Refers to the forecast average temperature
     */
    private float $temperature;
    /**
     * @var string $weather Refers to the weather forecasted
     */
    private string $weather;

    /**
     * @param string $date Refers to the forecast date
     * @param string $day Refers to the forecast day
     * @param float $temperature Refers to the forecast average temperature
     * @param string $weather Refers to the weather forecasted
     *
     * Upon instantiation, assigns values to the date, day, temperature and weather properties
     */
    public function __construct(string $date, string $day, float $temperature, string $weather)
    {
        $this->date = $date;
        $this->day = $day;
        $this->temperature = $temperature;
        $this->weather = $weather;
    }

    /**
     * @return string Retrieves the forecast date
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string Retrieves the forecast day
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @return float Retrieves the forecast average temperature
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return string Retrieves the forecast weather
     */
    public function getWeather(): string
    {
        return $this->weather;
    }


}