<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ClientValidator
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $translator;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ) {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function validateClient(array $data)
    {
        $constraint = new Assert\Collection([
            'last_name' => new Assert\Length(['min' => 3]),
            'first_name' => new Assert\Length(['min' => 3]),
            'password' => new Assert\Length(['min' => 8]),
            'username' => new Assert\Email(),
        ]);

        $validator = $this->validator->validate($data, $constraint);

        $clientRepo = $this->entityManager->getRepository(Client::class);

        $entity = $clientRepo->findOneBy(['username' => $data['username']]);

        if ($entity) {
            $validator->add(new ConstraintViolation($this->translator->trans('Username has been take'), null, [], null, null, null));
        }

        return $validator;
    }
}
