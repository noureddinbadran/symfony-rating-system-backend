<?php

namespace App\Controller;

use App\Repository\RatingAspectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/rating-aspects")
 */
class RatingAspectController extends AbstractController
{

    private $ratingAspectRepository;

    public function __construct(RatingAspectRepository $ratingAspectRepository)
    {
        $this->ratingAspectRepository = $ratingAspectRepository;
    }

    /**
     * @Route("", methods={"GET","HEAD"})
     */
    public function getRatingAspects(): Response
    {
        $ratingAspects = $this->ratingAspectRepository->findAll();
        return $this->json($ratingAspects);
    }
}
