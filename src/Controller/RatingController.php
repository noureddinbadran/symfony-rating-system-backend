<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Service\RatingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/rating")
 */
class RatingController extends AbstractController
{

//    private $ratingRepository;
//
//    public function __construct(RatingRepository $ratingRepository)
//    {
//        $this->ratingRepository = $ratingRepository;
//    }

    /**
     * @Route("", methods="POST", name="rating.store")
     */
    public function store(Request $request, RatingService $ratingService, ClientRepository $clientRepository): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $client = $clientRepository->find(1);
        return $this->json($ratingService->addRating($data, $client));
    }

}
