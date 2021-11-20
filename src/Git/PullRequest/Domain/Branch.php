<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

final class Branch
{
    private function __construct(
        private string $name
    ) {
    }

    public static function build(string $name): self
    {
        return new self($name);
    }

    public function name(): string
    {
        return $this->name;
    }
}
