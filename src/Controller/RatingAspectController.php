<?php

namespace App\Controller;

use App\Repository\RatingAspectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("api/rating-aspects")
 */
class RatingAspectController extends BaseController
{

    private $ratingAspectRepository;

    public function __construct(RatingAspectRepository $ratingAspectRepository)
    {
        $this->ratingAspectRepository = $ratingAspectRepository;
    }

    /**
     * @Route("", methods={"GET"})
     * @OA\Get(
     *     path="/api/rating-aspects",
     *     description="Use this API to get the rating aspects",
     *     @OA\Response(
     *          response="200",
     *          description="You will receive an array of the rating aspects"
     *      ),
     * )
     */
    public function getRatingAspects(): Response
    {
        $ratingAspects = $this->ratingAspectRepository->findAll();
        return $this->successResponse($ratingAspects);
    }
}
