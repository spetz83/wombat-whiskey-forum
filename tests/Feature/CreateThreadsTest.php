<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Tests\DatabaseTestCase;

class CreateThreadsTest extends DatabaseTestCase
{
    /**
     *
     * @test
     */
    public function anAuthUserCanCreateNewThreads()
    {
        $this->signIn();

        $thread = $this->make('App\Thread');
        $this->post('/threads', $thread->toArray());

        $response = $this->get($thread->path());
        $response->assertSee($thread->title)->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function guestsCannotCreateThreads()
    {
        $this->expectException(AuthenticationException::class);
        $thread = $this->make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }
}
