<?php

declare(strict_types=1);

namespace App\Git\Healthcheck\Infrastructure\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HealthController
{
    #[Route(path: '/health', name: 'health')]
    public function __invoke(): Response
    {
        return new JsonResponse();
    }
}
