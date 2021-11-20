<?php

declare(strict_types=1);

namespace App\Tests\Git\PullRequest\Infrastructure\Repository;

use App\Git\PullRequest\Domain\Branch;
use App\Git\PullRequest\Domain\PullRequest;
use App\Git\PullRequest\Domain\PullRequests;
use App\Git\PullRequest\Domain\Repository;
use App\Git\PullRequest\Domain\Repository\PullRequestRepositoryInterface;
use App\Tests\Git\PullRequest\Domain\PullRequestFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class FakePullRequestRepository implements PullRequestRepositoryInterface
{
    use Factories;

    public function findAll(Repository $repository, Branch $branch): PullRequests
    {
        return PullRequests::build(array_map(
            /**
             * @param Proxy<PullRequest> $proxy
             */
            function (Proxy $proxy): PullRequest {
                return $proxy->object();
            },
            PullRequestFactory::createMany(10)
        ));
    }
}
