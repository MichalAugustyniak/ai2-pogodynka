<?php

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use function Symfony\Component\Clock\now;

class WeatherUtil
{
    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository) {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $location->getMeasurements()->filter(function (Measurement $measurement)
        {
            return $measurement->getDate() > now();
        })->getValues();
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $country, string $city): array
    {
        $location = $this->locationRepository->findOneBy(['country' => $country, 'city' => $city]);

        return $this->getWeatherForLocation($location);
    }
}