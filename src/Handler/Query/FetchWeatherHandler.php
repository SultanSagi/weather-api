<?php

namespace App\Handler\Query;

use App\Message\Query\FetchWeatherQuery;
use Doctrine\Persistence\ManagerRegistry;

class FetchWeatherHandler
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function __invoke(FetchWeatherQuery $query)
    {
        $entityManager = $this->doctrine->getManager();
        $repository = $entityManager->getRepository(Weather::class);

        $weather = $repository->findAll();
    }
}