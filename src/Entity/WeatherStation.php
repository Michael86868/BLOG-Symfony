<?php

namespace App\Entity;

use App\Repository\WeatherStationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherStationRepository::class)
 */
class WeatherStation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $dallasTemperature1;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $dallasTemperature2;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $dallasTemperature3;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $bmeTemperature;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $bmePressure;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $bmeAltitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $bmeHumidity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $gasMQ;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDallasTemperature1(): ?float
    {
        return $this->dallasTemperature1;
    }

    public function setDallasTemperature1(float $dallasTemperature1): self
    {
        $this->dallasTemperature1 = $dallasTemperature1;

        return $this;
    }

    public function getDallasTemperature2(): ?float
    {
        return $this->dallasTemperature2;
    }

    public function setDallasTemperature2(float $dallasTemperature2): self
    {
        $this->dallasTemperature2 = $dallasTemperature2;

        return $this;
    }

    public function getDallasTemperature3(): ?float
    {
        return $this->dallasTemperature3;
    }

    public function setDallasTemperature3(float $dallasTemperature3): self
    {
        $this->dallasTemperature3 = $dallasTemperature3;

        return $this;
    }

    public function getBmeTemperature(): ?float
    {
        return $this->bmeTemperature;
    }

    public function setBmeTemperature(float $bmeTemperature): self
    {
        $this->bmeTemperature = $bmeTemperature;

        return $this;
    }

    public function getBmePressure(): ?float
    {
        return $this->bmePressure;
    }

    public function setBmePressure(float $bmePressure): self
    {
        $this->bmePressure = $bmePressure;

        return $this;
    }

    public function getBmeAltitude(): ?float
    {
        return $this->bmeAltitude;
    }

    public function setBmeAltitude(float $bmeAltitude): self
    {
        $this->bmeAltitude = $bmeAltitude;

        return $this;
    }

    public function getBmeHumidity(): ?float
    {
        return $this->bmeHumidity;
    }

    public function setBmeHumidity(float $bmeHumidity): self
    {
        $this->bmeHumidity = $bmeHumidity;

        return $this;
    }

    public function getGasMQ(): ?float
    {
        return $this->gasMQ;
    }

    public function setGasMQ(float $gasMQ): self
    {
        $this->gasMQ = $gasMQ;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
