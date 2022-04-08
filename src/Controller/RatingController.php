<?php

namespace App\Controller;

use App\Repository\HotelRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{

//    /**
//     * @Route("/rating", methods={"GET","HEAD"})
//     */
//    public function getRatingAspects(): Response
//    {
//        $ratingAspects = $this->ratingAspectRepository->find(1);
//        return $this->json($ratingAspects);
//    }
}
