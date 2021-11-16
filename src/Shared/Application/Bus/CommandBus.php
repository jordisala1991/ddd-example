<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus;

use App\Shared\Domain\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
