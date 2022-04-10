<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Rating;
use App\Entity\RatingAspect;
use App\Entity\RatingDetail;
use App\Repository\RatingAspectRepository;
use Doctrine\ORM\EntityManagerInterface;

class RatingService
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function addRating(array $data, Client $client): bool
    {
        $project = $this->getProject($data['project_id']);

        if (!$project) {
            return false;
        }
        // client can create only one review by project
        $checkRating = $this->getRating($client, $project);

        if ($checkRating) {
            return false;
        }

//        $ratingData = $this->newRattingData($data['ratingData']);

        $rating = new Rating();
        $rating->setClient($client);
        $rating->setProject($project);
        $rating->setComment($data['comment']);
        $rating->setScore($data['overall_satisfaction']);

//        $rating->setRating($ratingData->getRating());

        $this->entityManager->persist($rating);

//        $ratingData->setRating($rating);

//        $this->entityManager->persist($ratingData);
        $this->entityManager->flush();

        foreach ($data['details'] as $key => $value)
        {
            $ratingAspect = $this->getRatingAspect($key);

            $ratingDetail = new RatingDetail();
            $ratingDetail->setRatingAspectId($ratingAspect->getId());
            $ratingDetail->setRatingId($rating->getId());
            $ratingDetail->setScore($value);
            $this->entityManager->persist($ratingDetail);
        }

        $this->entityManager->flush();

        return true;
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