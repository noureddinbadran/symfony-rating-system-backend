<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Service\AuthService;
use App\Service\RatingService;
use App\Validator\ClientValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/register", methods="POST", name="register")
     */
    public function register(Request $request, AuthService $authService, ClientValidator $clientValidator)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return $this->json([
                'msg' => 'mssing required data'
            ], Response::HTTP_BAD_REQUEST);
        }

        $validationRequest = $clientValidator->validateClient($data);

        if ($validationRequest->count() > 0) {
            return $this->json([
                'msg' => (string) $validationRequest
            ], Response::HTTP_BAD_REQUEST);
        }

        if($authService->register($data))
            return $this->json([
                'msg' => 'client created!'
            ]);
        else
            return $this->json([
                'msg' => 'something went wrong, try again'
            ], 400);
    }
}