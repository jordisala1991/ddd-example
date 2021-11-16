<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application;

use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use App\Git\PullRequest\Domain\Repository\PullRequestRepositoryInterface;

final class PullRequestService
{
    public function __construct(
        private PullRequestRepositoryInterface $repository
    ) {
    }

    public function findPullRequests(Repository $repository, Branch $branch): PullRequests
    {
        return $this->repository->findAll($repository, $branch);
    }
}
