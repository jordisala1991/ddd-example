<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application;

use App\Git\PullRequest\Domain\PullRequestRepositoryInterface;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;

final class PullRequestService
{
    public function __construct(
        private PullRequestRepositoryInterface $repository
    ) {
    }

    public function findPullRequests(Repository $repository): PullRequests
    {
        return $this->repository->findAll($repository);
    }
}
