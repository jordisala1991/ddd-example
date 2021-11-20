<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

/**
 * @phpstan-import-type PullRequestArray from PullRequest
 */
final class PullRequests
{
    /**
     * @param PullRequest[] $pullRequests
     */
    private function __construct(
        private array $pullRequests
    ) {
    }

    /**
     * @param PullRequest[] $pullRequests
     */
    public static function build(array $pullRequests): self
    {
        return new self($pullRequests);
    }

    /**
     * @return PullRequest[]
     */
    public function pullRequests(): array
    {
        return $this->pullRequests;
    }
}
