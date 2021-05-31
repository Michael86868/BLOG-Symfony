<?php

namespace App\Controller;

use App\Repository\WeatherStationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherStationController extends AbstractController
{
    /**
     * @Route("/arduino", name="weather_station", methods={"GET"})
     * @throws NonUniqueResultException
     */
    public function index(WeatherStationRepository $weatherStationRepository): Response
    {

        return $this->render('weather_station/index.html.twig', [
            'lastRecord' => $weatherStationRepository->findLastRecord(),
            'data' => $weatherStationRepository->findAll(),
        ]);
    }
}
