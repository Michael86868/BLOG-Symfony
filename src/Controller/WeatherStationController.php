<?php

namespace App\Controller;

use App\Repository\WeatherStationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class WeatherStationController extends AbstractController
{
    /**
     * @Route("/arduino", name="weather_station", methods={"GET"})
     * @throws NonUniqueResultException
     * @throws JsonException
     */
    public function index(WeatherStationRepository $weatherStationRepository): Response
    {
        $originalTime = [];

        $datetime = array_reverse(array_column($weatherStationRepository->findOneColumn('createdAt'), 'createdAt'));

        foreach($datetime as $date){
            $originalTime[] = $date->format('H:i');
        }

        return $this->render('weather_station/index.html.twig', [
            'lastRecord' => $weatherStationRepository->findLastRecord(),
            'data' => $weatherStationRepository->findAll(),
            'dallas1' => json_encode(array_reverse(array_column($weatherStationRepository->findOneColumn('dallasTemperature1'), 'dallasTemperature1')), JSON_THROW_ON_ERROR),
            'dallas2' => json_encode(array_reverse(array_column($weatherStationRepository->findOneColumn('dallasTemperature2'), 'dallasTemperature2')), JSON_THROW_ON_ERROR),
            'dallas3' => json_encode(array_reverse(array_column($weatherStationRepository->findOneColumn('dallasTemperature3'), 'dallasTemperature3')), JSON_THROW_ON_ERROR),
            'bmeTemp' => json_encode(array_reverse(array_column($weatherStationRepository->findOneColumn('bmeTemperature'), 'bmeTemperature')), JSON_THROW_ON_ERROR),
            'datetime' => $originalTime,
        ]);
    }
}
