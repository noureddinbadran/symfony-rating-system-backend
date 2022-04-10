<?php

namespace App\DataFixtures;

use App\Entity\RatingAspect;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RatingAspectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //TODO it'd be better to store them into a separated file like excel-sheet
        $aspects = [
            [
                'name' => 'Communication',
                'description' => 'How responsive was the Vico throughout the duration of the project?',
                'code' => 'communication'
            ],
            [
                'name' => 'Quality of work',
                'description' => 'How satisfied are you with the deliverables provided by the Vico?',
                'code' => 'quality_of_work'
            ],
            [
                'name' => 'Value for money',
                'description' => 'How satisfied are you with thw pricing of this project compared to the work delivered?',
                'code' => 'value_for_money'
            ],
        ];

        // storing the aspects
        foreach ($aspects as $aspect) {
            $entity = new RatingAspect();
            $entity->setName($aspect['name']);
            $entity->setDescription($aspect['description']);
            $entity->setCode($aspect['code']);

            $manager->persist($entity);

        }

        $manager->flush();
    }
}
