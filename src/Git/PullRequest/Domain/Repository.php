<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

final class Repository
{
    private function __construct(
        private string $owner,
        private string $name
    ) {
    }

    public static function build(string $owner, string $name): self
    {
        return new self($owner, $name);
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
