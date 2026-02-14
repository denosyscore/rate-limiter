<?php

declare(strict_types=1);

namespace CFXP\Core\RateLimiter\Middleware;

use CFXP\Core\Http\Middleware\ThrottleRequestsMiddleware;
use CFXP\Core\RateLimiter\RateLimiter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ThrottlePasswordResetMiddleware implements MiddlewareInterface
{
    private ThrottleRequestsMiddleware $throttle;

    public function __construct(
        RateLimiter $rateLimiter,
        int $maxAttempts = 3,
        int $decayMinutes = 1,
    ) {
        $this->throttle = new ThrottleRequestsMiddleware(
            $rateLimiter,
            $maxAttempts,
            $decayMinutes,
            'password_reset'
        );
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->throttle->process($request, $handler);
    }
}
