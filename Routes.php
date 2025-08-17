<?php

declare(strict_types=1);

final class Routes extends \Falcon\Routing\RouteRegistrar
{
    public function register(): void
    {
        $this->get('/test', function () {
            echo 'handling /test!!';
        });

        $this->get('/v1/users', function () {
            echo 'handling /v1/users!!';
        });

        $this->get('/sample-endpoint', SampleController::class, 'process');
    }
}
