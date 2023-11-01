<?php

declare(strict_types=1);

namespace App\DTO\AgeCalculator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final readonly class AgeCalculatorDTO
{
    public function __construct(
        public \DateTimeImmutable $birthday,
        public \DateTimeImmutable $calcDate = new \DateTimeImmutable(),
    ) {
    }

    #[Assert\Callback]
    public function validateLocation(ExecutionContextInterface $context): void
    {
        if ($this->calcDate < $this->birthday) {
            $context->buildViolation('Birthday must be higter than calcDate')
                ->atPath('birthday')
                ->addViolation();
        }
    }
}
