<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Infrastructure\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class GithubApi
{
    private const PULLS_PER_PAGE = 100;
    private const PULLS_PATH = '/repos/%s/%s/pulls';

    public function __construct(
        private HttpClientInterface $githubClient
    ) {
    }

    public function pulls(string $owner, string $repository, int $page = 1): ResponseInterface
    {
        return $this->githubClient->request('GET', sprintf(static::PULLS_PATH, $owner, $repository), [
            'query' => [
                'state' => 'all',
                'per_page' => static::PULLS_PER_PAGE,
                'page' => $page,
            ],
        ]);
    }
}
