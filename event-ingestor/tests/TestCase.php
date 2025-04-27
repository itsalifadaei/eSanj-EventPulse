<?php

namespace Tests;

use App\Repositories\EventRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected EventRepository $eventRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(EventRepository::class);
    }
}
