<?php

namespace App\Handler\Command;

use App\Entity\Weather;
use App\Message\Command\CreateWeather;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CreateWeatherHandler
{
    private $doctrine;
    private $parameterBag;
    private $client;

    public function __construct(ManagerRegistry $doctrine, ParameterBagInterface $parameterBag, HttpClientInterface $client)
    {
        $this->doctrine = $doctrine;
        $this->parameterBag = $parameterBag;
        $this->client = $client;
    }
    
    public function __invoke(CreateWeather $query)
    {
        $cities = [
            ['name' => 'Riga', 'country' => 'LV'],
            ['name' => 'New York', 'country' => 'US'],
        ];
        
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository(Weather::class);

        foreach($cities as $city) {
            $location = $city['name'];
            $apiKey = $this->parameterBag->get('app.weatherApiKey');
            $url = $this->parameterBag->get('app.weatherUrl');
            $units = $city['country'] === 'US' ? 'imperial' : 'metric';
            $res = $this->client->request(
                'GET',
                "{$url}?q={$location}&appid={$apiKey}&units={$units}"
            );
            $res = $res->toArray();
            
            $weather = $repository->findOneBy(['city' => $location]);
            if (!$weather) {
                // create new
                $weather = new Weather;
                $weather->setTemp($res['main']['temp']);
                $weather->setWind($res['wind']['speed']);
                $weather->setCountry($res['sys']['country']);
                $weather->setCity($location);
                $entityManager->persist($weather);
                $entityManager->flush();
            } else {
                $weather->setTemp($res['main']['temp']);
                $weather->setWind($res['wind']['speed']);
                $entityManager->flush();
            }
        }
    }
}