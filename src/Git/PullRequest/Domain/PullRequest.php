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
    private function __construct(
        private string $name
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return new self(
            $data['title'],
        );
    }

    public function name(): string
    {
        return $this->name;
    }
}
