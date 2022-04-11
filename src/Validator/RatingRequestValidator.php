<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

final class RatingRequestValidator
{
    /**
     * @Assert\NotNull
     * @Assert\NotBlank()
     */
    public int $project_id;

    /**
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Positive
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "You must be between {{ min }} and {{ max }}",
     * )
     */
    public float $overall_satisfaction;

    /**
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    public string $comment;

    /**
     * @Assert\NotNull
     * @Assert\Valid
     */
    public RatingDetailsValidator $details;
}
