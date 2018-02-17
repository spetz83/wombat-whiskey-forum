<?php

namespace Tests\Feature;

use App\Thread;
use Tests\DatabaseTestCase;

class ThreadsTest extends DatabaseTestCase
{
    /** @var Thread */
    private $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = $this->create('App\Thread');
    }

    /**
     * @test
     */
    public function aUserCanBrowseThreads()
    {
        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function aUserCanReadASingleThread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function userCanReadRepliesAttachedToThread()
    {
        $reply = $this->create('App\Reply', ['thread_id' => $this->thread->id]);
        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);
    }
}
