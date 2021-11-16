<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

final class Branch
{
    public function __construct(
        private string $name
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }
}
