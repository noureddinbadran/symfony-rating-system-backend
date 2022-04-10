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

    /**
     * @Route("/login", methods="POST", name="login")
     */
    public function login(Request $request, AuthService $authService, LoggerInterface $logger)
    {
        try {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!$data) {
            return $this->json([
                'msg' => 'mssing required data'
            ], Response::HTTP_BAD_REQUEST);
        }

            $token = $authService->login($data);

            return $this->json([
                'data' => [
                    'token' => $token
                ]
            ]);
        } catch (\Throwable $e)
        {
            return $this->json([
                'data' => null,
                'msg' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}