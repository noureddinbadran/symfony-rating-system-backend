<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class AuthService
{
    private $clientRepository;
    private $logger;
    private $entityManager;

    public function __construct(ClientRepository $clientRepository, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->clientRepository = $clientRepository;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function register($data)
    {
        try {
            $this->logger->error('yes');
            $client = new Client();
            $client->setUsername($data['username']);
            $client->setPassword($data['password']);
            $client->setFirstName($data['first_name']);
            $client->setLastName($data['last_name']);
            $client->setCreated(new \DateTime());

            $this->clientRepository->add($client);

            return true;
        } catch (\Throwable $e)
        {
            $this->logger->error($e->getMessage());
            return false;
        }
    }

    public function login($data)
    {
        $clientRepo = $this->entityManager->getRepository(Client::class);

        $entity = $clientRepo->findOneBy(['username' => $data['username']]);

        if(!$entity)
            throw new \Exception('Invalid credentials', 401);

        return 'token';
    }
}