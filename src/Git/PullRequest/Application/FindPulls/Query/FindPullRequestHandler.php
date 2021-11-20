<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application\FindPulls\Query;

use App\Git\PullRequest\Domain\Repository\PullRequestRepositoryInterface;
use App\Shared\Domain\QueryHandler;

class FindPullRequestHandler implements QueryHandler
{
    public function __construct(
        private PullRequestRepositoryInterface $pullRequestRepository
    ) {
    }

    public function __invoke(FindPullRequestQuery $query): FindPullRequestPresenter
    {
        return FindPullRequestPresenter::write($this->pullRequestRepository->findAll(
            $query->repository(),
            $query->branch()
        ));
    }
}
