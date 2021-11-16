<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure;

use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\PullRequest;
use App\Git\PullRequest\Domain\PullRequestRepositoryInterface;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class GithubPullRequestRepository implements PullRequestRepositoryInterface
{
    private const PULLS_PER_PAGE = 100;
    private const PULLS_PATH = '/repos/%s/%s/pulls';

    public function __construct(
        private HttpClientInterface $githubClient
    ) {
    }

    public function findAll(Repository $repository, Branch $branch): PullRequests
    {
        $pullRequests = [];

        $response = $this->pulls($repository, $branch);
        $totalPages = $this->getTotalPages($response);

        $responses = [$response];

        for ($page = 2; $page <= $totalPages; ++$page) {
            $responses[] = $this->pulls($repository, $branch, $page);
        }

        foreach ($responses as $response) {
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                continue;
            }

            foreach ($response->toArray() as $rawPull) {
                $pullRequests[] = PullRequest::fromArray($rawPull);
            }
        }

        return new PullRequests($pullRequests);
    }

    private function pulls(Repository $repository, Branch $branch, int $page = 1): ResponseInterface
    {
        return $this->githubClient->request('GET', sprintf(static::PULLS_PATH, $repository->owner(), $repository->name()), [
            'query' => [
                'state' => 'all',
                'per_page' => static::PULLS_PER_PAGE,
                'base' => $branch->name(),
                'page' => $page,
            ],
        ]);
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

        preg_match('/[&?]page=(\d+)/', $lastPageLink, $matches);

        return (int) ($matches[1] ?? 1);
    }
}
