<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

/**
 * @phpstan-type PullRequestArray = array{
 *     name: string,
 * }
 */
final class PullRequest
{
    public function __construct(
        private string $name
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @phpstan-return PullRequestArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name(),
        ];
    }
}
