<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class CreateThreadsTest extends DatabaseTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    /**
     * @test
     */
    public function anAuthUserCanCreateNewThreads()
    {
        $this->signIn();

        $thread = $this->make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function threadsRequireTitles()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function threadsRequireBodies()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function threadsRequireAChannel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * @test
     */
    public function guestsCannotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads')->assertRedirect('/login');
    }

    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = $this->make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
