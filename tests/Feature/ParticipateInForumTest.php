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
    public function a_user_can_post_a_reply_in_a_thread()
    {
        $this->signIn();

        $thread = create('Thread');

        $reply = make('Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = create('Thread');

        $reply = make('Reply', ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
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

        $this->delete('replies/' . $reply->id)->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
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

        $this->patch('replies/' . $reply->id)
        ->assertRedirect('login');

        $this->signIn()
            ->patch('replies/' . $reply->id)
            ->assertStatus(403);
    }
}
