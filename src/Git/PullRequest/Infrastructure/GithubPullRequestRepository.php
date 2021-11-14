<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure;

use App\Git\PullRequest\Domain\PullRequest;
use App\Git\PullRequest\Domain\PullRequestRepositoryInterface;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use App\Git\PullRequest\Infrastructure\Api\GithubApi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class GithubPullRequestRepository implements PullRequestRepositoryInterface
{
    public function __construct(
        private GithubApi $githubApi
    ) {
    }

    public function findAll(Repository $repository): PullRequests
    {
        $pullRequests = new PullRequests();
        $response = $this->githubApi->pulls($repository->owner(), $repository->name());

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            return $pullRequests;
        }

        foreach ($response->toArray() as $rawPull) {
            $pullRequests->addPullRequest($this->fromRawPull($rawPull));
        }

        $totalPages = $this->getTotalPages($response);
        $responses = [];

        for ($page = 2; $page <= $totalPages; ++$page) {
            $responses[] = $this->githubApi->pulls($repository->owner(), $repository->name(), $page);
        }

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

    private function getTotalPages(ResponseInterface $response): int
    {
        $headers = $response->getHeaders();
        $links = $headers['link'][0] ?? null;

        if (null === $links) {
            return 1;
        }

        $linksArray = explode(', ', $links);
        $lastPageLink = $linksArray[1] ?? null;

        if (null === $lastPageLink) {
            return 1;
        }

        preg_match('/page=(\d+)/', $lastPageLink, $matches);

        return (int) ($matches[1] ?? 1);
    }
}
