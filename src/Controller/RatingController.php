<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Service\RatingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
 * @Route("api/rating")
 */
class RatingController extends AbstractController
{
    /**
     * @Route("", methods="POST", name="rating.store")
     * @Security(name="Bearer")
     */
    public function store(Request $request, RatingService $ratingService, ClientRepository $clientRepository): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $client = $this->getUser();
        return $this->json($ratingService->addRating($data, $client));
    }

}
