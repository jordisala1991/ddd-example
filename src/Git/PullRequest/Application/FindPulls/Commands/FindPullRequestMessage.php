<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application\FindPulls\Commands;

use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\Repository;
use App\Shared\Domain\Query;

class FindPullRequestMessage implements Query
{
    public function __construct(
        private Repository $repository,
        private Branch $branch
    ) {
    }

    public function repository(): Repository
    {
        return $this->repository;
    }

    public function branch(): Branch
    {
        return $this->branch;
    }
}
