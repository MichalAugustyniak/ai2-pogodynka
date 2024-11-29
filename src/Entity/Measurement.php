<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $max_celsius = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $min_celsius = null;

    #[ORM\Column]
    private ?int $pressure_hpa = null;

    #[ORM\Column]
    private ?int $wind_speed_kmh = null;

    #[ORM\Column(length: 255)]
    private ?string $wind_direction = null;

    #[ORM\Column]
    private ?int $humidity_percent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMaxCelsius(): ?string
    {
        return $this->max_celsius;
    }

    public function setMaxCelsius(string $max_celsius): static
    {
        $this->max_celsius = $max_celsius;

        return $this;
    }

    public function getMinCelsius(): ?string
    {
        return $this->min_celsius;
    }

    public function setMinCelsius(string $min_celsius): static
    {
        $this->min_celsius = $min_celsius;

        return $this;
    }

    public function getPressureHpa(): ?int
    {
        return $this->pressure_hpa;
    }

    public function setPressureHpa(int $pressure_hpa): static
    {
        $this->pressure_hpa = $pressure_hpa;

        return $this;
    }

    public function getWindSpeedKmh(): ?int
    {
        return $this->wind_speed_kmh;
    }

    public function setWindSpeedKmh(int $wind_speed_kmh): static
    {
        $this->wind_speed_kmh = $wind_speed_kmh;

        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(string $wind_direction): static
    {
        $this->wind_direction = $wind_direction;

        return $this;
    }

    public function getHumidityPercent(): ?int
    {
        return $this->humidity_percent;
    }

    public function setHumidityPercent(int $humidity_percent): static
    {
        $this->humidity_percent = $humidity_percent;

        return $this;
    }

    public function getFahrenheit(): float
    {
        $average = ($this->getMaxCelsius() + $this->getMinCelsius()) / 2;
        return ($average * 9/5) + 32;
    }
}
