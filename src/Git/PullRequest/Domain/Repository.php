<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

final class Repository
{
    public function __construct(
        private string $owner,
        private string $name
    ) {
    }

    public function owner(): string
    {
        return $this->owner;
    }

    public function name(): string
    {
        return $this->name;
    }
}
