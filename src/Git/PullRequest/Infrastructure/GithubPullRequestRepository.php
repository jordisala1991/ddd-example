<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure;

use App\Git\PullRequest\Domain\PullRequest;
use App\Git\PullRequest\Domain\PullRequestRepositoryInterface;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use App\Git\PullRequest\Infrastructure\Api\GithubApi;
use Symfony\Component\HttpFoundation\Response;

final class GithubPullRequestRepository implements PullRequestRepositoryInterface
{
    public function __construct(
        private GithubApi $githubApi
    ) {
    }

    public function findAll(Repository $repository): PullRequests
    {
        $pullRequests = new PullRequests();
        $responses = $this->githubApi->allPulls($repository);

        foreach ($responses as $response) {
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                continue;
            }

            foreach ($response->toArray() as $rawPull) {
                $pullRequests->addPullRequest($this->fromRawPull($rawPull));
            }
        }

        return $pullRequests;
    }

    /**
     * @param array<string, mixed> $rawPull
     */
    private function fromRawPull(array $rawPull): PullRequest
    {
        return new PullRequest($rawPull['title']);
    }
}
