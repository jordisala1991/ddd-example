<?php

namespace App\Tests\Git\PullRequest\Domain;

use App\Git\PullRequest\Domain\PullRequest;
use Zenstruck\Foundry\ModelFactory;

/**
 * @phpstan-extends ModelFactory<PullRequest>
 */
class PullRequestFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    public function getDefaults(): array
    {
        return [
            'title' => self::faker()->name(),
        ];
    }

    protected function initialize(): static
    {
        return $this->withoutPersisting()->instantiateWith(function (array $attributes, string $class): object {
            return PullRequest::fromArray($attributes);
        });
    }

    protected static function getClass(): string
    {
        return PullRequest::class;
    }
}
