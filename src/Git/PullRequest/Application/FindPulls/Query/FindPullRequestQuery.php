<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application\FindPulls\Query;

use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\Repository;
use App\Shared\Domain\Query;

class FindPullRequestQuery implements Query
{
    private function __construct(
        private Repository $repository,
        private Branch $branch
    ) {
    }

    public static function build(Repository $repository, Branch $branch): self
    {
        return new self(
            $repository,
            $branch
        );
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
