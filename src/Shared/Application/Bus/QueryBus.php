<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus;

use App\Shared\Domain\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
