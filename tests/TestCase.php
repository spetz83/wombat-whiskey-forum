<?php

namespace Tests;

use App\Exceptions\Handler;
use App\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var ExceptionHandler */
    protected $oldExceptionHandler;

    /**
     * @param string $class
     * @param array $attributes
     * @return mixed
     */
    protected function create($class, $attributes = [])
    {
        return factory($class)->create($attributes);
    }

    /**
     * @param string $class
     * @param array $attributes
     * @return mixed
     */
    protected function make($class, $attributes = [])
    {
        return factory($class)->make($attributes);
    }

    /**
     * @param User|null $user
     * @return $this
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?: $this->create('App\User');
        $this->actingAs($user);
        return $this;
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct(){}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}
