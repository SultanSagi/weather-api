<?php

namespace App\Controller;

use App\Entity\Weather;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TestController extends AbstractController
{
    /**
      * @Route("/test/number")
    */
    public function number(HttpClientInterface $client): array
    {
        $cities = [
            ['name' => 'Riga', 'country' => 'LV'],
            ['name' => 'New York', 'country' => 'US'],
        ];
        
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Weather::class);

        foreach($cities as $city) {
            $location = $city['name'];
            $apiKey = '400c72073669554d1dc38abdbaf0892f';
            $units = $city['country'] === 'US' ? 'imperial' : 'metric';
            $res = $client->request(
                'GET',
                "https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units={$units}"
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

        $weather = $repository->findAll();
        dd($weather);

        // $weather = new Weather;
        // $weather->setTemp("20");
        // $weather->setWind("352");
        // $weather->setCity("London");
        // $entityManager->persist($weather);
        // $entityManager->flush();

        $city = 'London';
        $repository = $entityManager->getRepository(Weather::class);
        // $weather = $repository->findOneBy(['city' => $city]);
        $weather = $repository->find(1);
        $entityManager->remove($weather);
        $entityManager->flush();
        // $weather = $repository->findAll();

        if (!$weather) {
            throw $this->createNotFoundException(
                'No weather found for city '.$city
            );
        }
        
        // return new Response(
        //     'as'
        //     // 'Saved new product with id '.$weather->getId()
        //     // $weather[0]->getCity()
        // );
    }
}