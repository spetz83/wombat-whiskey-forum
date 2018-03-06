<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ParticipateInForumTest extends DatabaseTestCase
{
    /**
     * @test
     * @return void
     */
    public function anAuthenticatedUserCanParticipateInForumThreads()
    {
        $this->signIn();

        $thread = $this->create('App\Thread');
        $reply = $this->make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function aReplyRequiresABody()
    {
        $this->withExceptionHandling()->signIn();

        $thread = $this->create('App\Thread');
        $reply = $this->make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
