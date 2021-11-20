<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Application\FindPulls\Query;

use App\Git\PullRequest\Domain\PullRequest;
use App\Git\PullRequest\Domain\PullRequests;
use App\Shared\Domain\QueryPresenter;

class FindPullRequestPresenter implements QueryPresenter
{
    private function __construct(
        private PullRequests $pullRequests
    ) {
    }

    public static function write(PullRequests $pullRequests): self
    {
        return new self($pullRequests);
    }

    public function read(): array
    {
        return array_map(function (PullRequest $pullRequest): array {
            return [
                'name' => $pullRequest->name(),
            ];
        }, $this->pullRequests->pullRequests());
    }
}
