<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

final class RatingDetailsValidator
{
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
    public float $communication;

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
    public float $quality_of_work;

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
    public float $value_for_money;
}
