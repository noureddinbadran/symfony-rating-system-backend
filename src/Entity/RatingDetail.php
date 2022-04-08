<?php

namespace App\Entity;

use App\Repository\RatingDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingDetailRepository::class)
 */
class RatingDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating_aspect_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRatingId(): ?int
    {
        return $this->rating_id;
    }

    public function setRatingId(int $rating_id): self
    {
        $this->rating_id = $rating_id;

        return $this;
    }

    public function getRatingAspectId(): ?int
    {
        return $this->rating_aspect_id;
    }

    public function setRatingAspectId(int $rating_aspect_id): self
    {
        $this->rating_aspect_id = $rating_aspect_id;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
