<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil) {
        $this->weatherUtil = $weatherUtil;
    }

    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] bool $twig = false,
        #[MapQueryParameter] string $format = 'json'
    ): Response
    {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            if ($format === 'csv') {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }

            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);
        }

        if ($format === 'csv') {
            $csvContent = "city,country,date,minCelsius,maxCelsius,fahrenheit\n";
            foreach ($measurements as $measurement) {
                $date = $measurement->getDate()->format('Y-m-d');
                $maxCelsius = $measurement->getMaxCelsius();
                $minCelsius = $measurement->getMinCelsius();
                $fahrenheit = $measurement->getFahrenheit();
                $csvContent .= sprintf("%s,%s,%s,%s,%s,%s\n", $city, $country, $date, $minCelsius, $maxCelsius, $fahrenheit);
            }

            return new Response(
                $csvContent,
                Response::HTTP_OK,
                ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="weather.csv"']
            );
        }

        return $this->json([
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'maxCelsius' => $m->getMaxCelsius(),
                'minCelsius' => $m->getMinCelsius(),
                'fahrenheit' => $m->getFahrenheit(),
            ], $measurements),
        ]);
    }
}
