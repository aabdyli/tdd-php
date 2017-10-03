<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('Thread');
    }

    /** @test */
    public function a_thread_can_make_a_string_of_the_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }

    /** @test */
    public function a_thread_should_have_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_have_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        // Given we have a thread
        // When the user subscribes to the thread
        $this->thread->subscribe($userId = 1);
        // Then we should be able to fetch all threads that the user has subscribed
       $this->assertCount(
           1,
           $this->thread->subscriptions()->where('user_id', $userId)->get()
        );
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        // When the user subscribes to the thread
        $this->thread->subscribe($userId = 1);
        // Then we should be able to fetch all threads that the user has subscribed

        $this->thread->unsubscribe($userId = 1);

        $this->assertCount(
           0,
           $this->thread->subscriptions()->where('user_id', $userId)->get()
        );

    }
}
