<?php

declare(strict_types=1);

namespace App\DTO\AgeCalculator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final readonly class AgeCalculatorDTO
{
    public function __construct(
        public \DateTimeImmutable $birthday,
        public \DateTimeImmutable $dateFrom = new \DateTimeImmutable(),
    ) {
    }

    #[Assert\Callback]
    public function validateLocation(ExecutionContextInterface $context): void
    {
        if ($this->dateFrom < $this->birthday) {
            $context->buildViolation('Birthday must be higter than dateFrom')
                ->atPath('birthday')
                ->addViolation();
        }
    }
}
