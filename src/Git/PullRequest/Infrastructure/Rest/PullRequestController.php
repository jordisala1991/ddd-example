<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure\Rest;

use App\Git\PullRequest\Application\FindPulls\Query\FindPullRequestQuery;
use App\Git\PullRequest\Domain\Branch;
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

    #[Route(path: '/api/github/{owner}/{repository}/pull-requests', name: 'repository_pull_requests', methods: ['POST'])]
    public function pullRequests(Request $request, string $owner, string $repository): Response
    {
        $branch = $request->query->get('branch', 'main');
        \assert(\is_string($branch));

        $presenter = $this->queryBus->handle(FindPullRequestQuery::build(
            Repository::build($owner, $repository),
            Branch::build($branch)
        ));

        return new JsonResponse($presenter->read());
    }
}
