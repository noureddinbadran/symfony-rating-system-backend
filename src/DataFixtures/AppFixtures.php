<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\Project;
use App\Entity\Vico;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $vico = $this->seedVico($manager);
        $member = $this->seedMember($manager);

        $this->seedProjects($vico, $member, $manager);
    }

    private function seedVico(ObjectManager $manager): Vico
    {
        $vico = new Vico();
        $vico->setCreated(new \DateTime());
        $vico->setName('vico name');

        $manager->persist($vico);
        $manager->flush();

        return $vico;
    }

    private function seedMember(ObjectManager $objectManager): Member
    {
        $member = new Member();
        $member->setUsername('member username');

        $objectManager->persist($member);
        $objectManager->flush();

        return $member;
    }

    private function seedProjects(
        Vico $vico,
        Member $member,
        ObjectManager $manager
    ): void {
        $projects = [
            ['title' => 'project 1'],
            ['title' => 'project 2'],
            ['title' => 'project 3'],
        ];

        foreach ($projects as $project) {
            $entity = new Project();

            $entity->setCreator($member);
            $entity->setVico($vico);
            $entity->setTitle($project['title']);
            $entity->setCreated(new \DateTime());

            $manager->persist($entity);
        }
        $manager->flush();
    }
}
