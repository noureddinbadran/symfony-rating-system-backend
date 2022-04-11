<?php

namespace App\Controller;

use App\Service\RatingService;
use App\Validator\RatingRequestValidator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

/**
 * @Route("api/rating")
 */
class RatingController extends BaseController
{
    /**
     * @Route("", methods="POST", name="rating.store")
     * @OA\Post(
     *     path="/api/rating",
     *     description="Use this API to rate a specific vico-project",
     * @OA\RequestBody(
     *      @OA\MediaType(
     *             mediaType="application/json",
     *          @OA\Schema(type="object",
     *              @OA\Property(property="project_id", type="integer"),
     *              @OA\Property(property="overall_satisfaction", type="double",description="It represents the rating of overall client's satisfaction",minLength=0,maxLength=5),
     *              @OA\Property(property="comment", type="string",description="It represents the review of the client"),
     *               @OA\Property(property="communication", type="double",minLength=0,maxLength=5),
     *               @OA\Property(property="quality_of_work", type="double",minLength=0,maxLength=5),
     *               @OA\Property(property="value_for_money", type="double",minLength=0,maxLength=5),
     *
     *              example={"project_id": 1,
     *                       "overall_satisfaction": 4,
     *                       "comment": "The project was fantastic",
     *                       "details": {
     *                          "communication": 4,
     *                          "quality_of_work": 2,
     *                          "value_for_money": 3.2
     *                       }
     *                      }
     *          )
     *         )
     * ),
     *     @OA\Response(
     *          response="200",
     *          description="Client created!"
     *      ),
     *     @OA\Response(
     *          response="400",
     *          description="Username has been take"
     *      ),
     *     @OA\Response(
     *          response="422",
     *          description="Mssing required data"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Server internal error"
     *     )
     * )
     */
    public function store(Request $request, RatingService $ratingService): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $validationsErrors = $this->validateRequest($request->getContent(), RatingRequestValidator::class);

            if ($validationsErrors->count() > 0) {
                return $this->createGenericErrorValidationResponse($validationsErrors);
            }

            $client = $this->getUser();
            $ratingService->addRating($data, $client);
            return $this->successResponse();

        } catch (\Throwable $e) {
            return $this->exceptionResponse($e);
        }
    }

}
