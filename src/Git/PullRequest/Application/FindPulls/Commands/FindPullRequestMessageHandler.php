<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application\FindPulls\Commands;

use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository\PullRequestRepositoryInterface;
use App\Shared\Domain\QueryHandler;

class FindPullRequestMessageHandler implements QueryHandler
{
    public function __construct(
        private PullRequestRepositoryInterface $pullRequestRepository
    ) {
    }

    public function __invoke(FindPullRequestMessage $message): PullRequests
    {
        return $this->pullRequestRepository->findAll(
            $message->repository(),
            $message->branch()
        );
    }
}
