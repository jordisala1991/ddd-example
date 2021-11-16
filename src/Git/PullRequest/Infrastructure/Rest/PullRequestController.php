<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure\Rest;

use App\Git\PullRequest\Application\FindPulls\Commands\FindPullRequestMessage;
use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use App\Shared\Application\Bus\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PullRequestController
{
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    #[Route(path: '/api/github/{owner}/{repository}/pull-requests', name: 'repository_pull_requests')]
    public function pullRequests(Request $request, string $owner, string $repository): Response
    {
        $branch = $request->query->get('branch', 'main');
        \assert(\is_string($branch));

        $pullRequests = $this->queryBus->handle(new FindPullRequestMessage(
            new Repository($owner, $repository),
            new Branch($branch)
        ));
        \assert($pullRequests instanceof PullRequests);

        return new JsonResponse($pullRequests->toArray());
    }
}