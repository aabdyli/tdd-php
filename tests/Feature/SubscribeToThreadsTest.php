<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'The reply',
        ]);

        $this->assertTrue($thread->isSubscribedTo);
        // $this->assertCount(1, auth()->user()->notification);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        $thread = create('Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->assertTrue($thread->isSubscribedTo);

        $this->delete($thread->path() . '/subscriptions');

        $this->assertFalse($thread->isSubscribedTo);
    }
}
