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
    public function __construct(
        private array $pullRequests = []
    ) {
    }

    public function addPullRequest(PullRequest $pullRequest): void
    {
        $this->pullRequests[] = $pullRequest;
    }

    /**
     * @return PullRequest[]
     */
    public function pullRequests(): array
    {
        return $this->pullRequests;
    }

    /**
     * @return PullRequestArray[]
     */
    public function toArray(): array
    {
        return array_map(function (PullRequest $pullRequest): array {
            return $pullRequest->toArray();
        }, $this->pullRequests());
    }
}
