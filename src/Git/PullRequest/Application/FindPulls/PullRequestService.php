<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application\FindPulls;

use App\Git\PullRequest\Application\FindPulls\Commands\FindPullRequestMessage;
use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use App\Shared\Application\Bus\QueryBus;

final class PullRequestService
{
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    public function findPullRequests(Repository $repository, Branch $branch): PullRequests
    {
        $pullRequests = $this->queryBus->handle(
            new FindPullRequestMessage($repository, $branch)
        );
        \assert($pullRequests instanceof PullRequests);

        return $pullRequests;
    }
}
