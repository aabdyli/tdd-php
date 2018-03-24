<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->post('/threads/some-slug/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('Thread');
        $reply = make('Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = create('Thread');

        $reply = make('Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function unauthorised_users_can_not_delete_replies()
    {
        $reply = create('Reply');

        $this->delete('replies/' . $reply->id)
        ->assertRedirect('login');

        $this->signIn()
            ->delete('replies/' . $reply->id)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_relpies()
    {
        $this->signIn();
        $reply = create('Reply', ['user_id' => auth()->id()]);

        $this->delete('replies/' . $reply->id);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->replies_count);
    }

    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply = create('Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'Test';
        $this->patch('replies/' . $reply->id, ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */
    public function unauthorised_users_can_not_update_replies()
    {
        $reply = create('Reply');

        $this->patch('/replies/' . $reply->id)
        ->assertRedirect('login');

        $this->signIn()
            ->patch('/replies/' . $reply->id)
            ->assertStatus(403);
    }

    /** @test */
    public function replies_that_contain_span_may_not_be_created()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('Thread');

        $reply = make('Reply', [
            'body' => 'Yahoo Customer Support',
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->signIn();

        $thread = create('Thread');

        $reply = make('Reply', ['body' => 'My simple reply.']);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(200);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }
}
