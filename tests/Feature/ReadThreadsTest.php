<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('Thread');
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function a_user_can_see_all_the_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_read_replies_on_a_thread()
    {
        $reply = create('Reply', ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_a_tag()
    {
        // Given we have a channel
        $channel = create('Channel');
        // And a thread in this channel and another not in this channel
        $threadInChannel = create('Thread', ['channel_id' => $channel->id]);
        // When we hit the endpoint of the channel
        $this->get('/threads/' . $channel->slug)
        // We should see only the thread that belongs to this channel
            ->assertSee($threadInChannel->title)
            ->assertDontSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('User', ['name' => 'JohnDoe']));

        $threadByJohn = create('Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = $this->thread;

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        // Given we have three threads
        // With 2 replies, 3 replies, 0 replies respectivly
        $threadWithTwoReplies = create('Thread');
        create('Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('Thread');
        create('Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        // When I filter all threads by popularity
        $response = $this->getJson('threads?popular=1')->json();
        // Then they should be returned from most replies to least
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
