<?php

declare(strict_types=1);

namespace App\Git\PullRequest\Domain;

interface PullRequestRepositoryInterface
{
    public function findAll(Repository $repository, Branch $branch): PullRequests;
}
