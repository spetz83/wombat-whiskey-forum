<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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
}
