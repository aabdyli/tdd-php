<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_create_threads()
    {
        $this->post('threads')
            ->assertRedirect('/login');
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->signIn();

        $thread = make('Thread');
        // When we hit the endpoint to create a new thread
        $response = $this->post('threads', $thread->toArray());
        // Then we visit the thread page
        // And we should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        create('Channel', [], 2);

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        // Given we have a user and a thread
        $this->signIn();
        $thread = create('Thread', ['user_id' => auth()->id()]);
        $reply = create('Reply', ['thread_id' => $thread->id]);

        // When we make a json request to delete the thread
        $this->json('DELETE', $thread->path())
            ->assertStatus(204);

        // We should not have the thread listed in the database
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function guests_can_not_delete_threads()
    {
        $thread = create('Thread');
        $this->delete($thread->path())
            ->assertRedirect('login');

        $this->signIn();
        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    public function threads_may_be_deleted_by_those_who_have_permission()
    {
        // TODO
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
