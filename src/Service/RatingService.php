<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Rating;
use App\Entity\RatingAspect;
use App\Entity\RatingDetail;
use App\Exceptions\UserException;
use App\Helpers\EnumManager\Enums\GeneralEnum;
use App\Repository\RatingAspectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class RatingService
{
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ) {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * @param array $data
     * @param Client $client
     * @throws UserException
     * @throws \Throwable
     */
    public function addRating(array $data, Client $client): void
    {
        // getting a project by project id
        $project = $this->getProject($data['project_id']);

        if (!$project)
            throw new UserException($this->translator->trans('Project not found'), GeneralEnum::NOT_FOUND, Response::HTTP_NOT_FOUND);

        // client can create only one review by project
        $checkRating = $this->getRating($client, $project);

        if ($checkRating)
            throw new UserException($this->translator->trans('You have already rated this project'), GeneralEnum::ALREADY_RATED, Response::HTTP_UNPROCESSABLE_ENTITY);


        // Adding the rating details ..
        try {
            // begin a new transaction
            $this->entityManager->beginTransaction();

            $rating = new Rating();
            $rating->setClient($client);
            $rating->setProject($project);
            $rating->setComment($data['comment']);
            $rating->setScore($data['overall_satisfaction']);

            $this->entityManager->persist($rating);

            $this->entityManager->flush();

            foreach ($data['details'] as $key => $value) {
                $ratingAspect = $this->getRatingAspect($key);

                $ratingDetail = new RatingDetail();
                $ratingDetail->setRatingAspectId($ratingAspect->getId());
                $ratingDetail->setRatingId($rating->getId());
                $ratingDetail->setScore($value);
                $this->entityManager->persist($ratingDetail);
            }

            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (\Throwable $e)
        {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function getRatingAspect($aspect_code): ?RatingAspect
    {
        $repoProject = $this
            ->entityManager
            ->getRepository(RatingAspect::class);

        return $repoProject->findOneBy([
            'code' => $aspect_code
        ]);
    }

    private function getProject(int $project_id): ?Project
    {
        $repoProject = $this
            ->entityManager
            ->getRepository(Project::class);

        return $repoProject->find($project_id);
    }

    private function getRating(Client $client, Project $project): ?Rating
    {
        $repoRating = $this
            ->entityManager
            ->getRepository(Rating::class);

        $result = $repoRating->findOneBy(
            [
                'client' => $client,
                'project' => $project,
            ]
        );

        return $result ?? null;
    }
}