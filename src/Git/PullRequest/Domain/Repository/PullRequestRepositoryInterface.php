<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain\Repository;

use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;

interface PullRequestRepositoryInterface
{
    public function findAll(Repository $repository, Branch $branch): PullRequests;
}
