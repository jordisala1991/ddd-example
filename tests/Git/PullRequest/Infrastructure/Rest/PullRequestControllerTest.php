<?php

declare(strict_types=1);

namespace App\Tests\Git\PullRequest\Infrastructure\Rest;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

final class PullRequestControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testThatShouldNotBeAbleToCallTheApiWithGetMethod(): void
    {
        $this->client->request('GET', '/api/github/sonata-project/SonataAdminBundle/pull-requests');

        $this->assertResponseStatusCodeSame(405);
    }

    public function testThatConsumptionReturnsData(): void
    {
        $this->client->request('POST', '/api/github/sonata-project/SonataAdminBundle/pull-requests');

        $this->assertCount(10, $this->getJsonResponse());
        $this->assertResponseStatusCodeSame(200);
    }

    private function getJsonResponse(): array
    {
        return json_decode($this->client->getResponse()->getContent(), true);
    }
}
