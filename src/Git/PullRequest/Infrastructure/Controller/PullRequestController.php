<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure\Controller;

use App\Git\PullRequest\Application\PullRequestService;
use App\Git\PullRequest\Domain\Repository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PullRequestController
{
    public function __construct(
        private PullRequestService $pullRequests
    ) {
    }

    #[Route(path: '/api/github/{owner}/{repository}/pull-requests', name: 'repository_pull_requests')]
    public function pullRequests(string $owner, string $repository): Response
    {
        $pullRequests = $this->pullRequests->findPullRequests(new Repository($owner, $repository));

        return new JsonResponse($pullRequests->toArray());
    }
}
