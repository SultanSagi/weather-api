<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use App\Message\Query\FetchWeatherQuery;
use App\Message\Command\CreateWeather;

class MessengerController extends AbstractController
{
    use HandleTrait;
    
    private $messageBus;
    
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    
    /**
     * @Route("/weather-data", name="weather-data")
     */
    public function index(): Response
    {
        $this->messageBus->dispatch(new FetchWeatherQuery);

        return new Response('Weather data');
    }

    /**
     * @Route("/weather/create", name="create-weather")
     */
    public function create(): Response
    {
        $this->messageBus->dispatch(new CreateWeather);

        return new Response('Weather data updated');
    }
}
