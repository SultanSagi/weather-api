<?php

namespace App\Controller;

use App\Entity\Weather;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
      * @Route("/test/number")
    */
    public function number(): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Weather::class);

        $weather = $repository->findAll();
        dd($weather);
    }
}