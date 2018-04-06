<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('User', ['name' => 'johnDoe']);

        $jane = create('User', ['name' => 'janeDoe']);

        $this->signIn($john);

        $thread = create('Thread');

        $reply = make('Reply', [
            'body' => ' Hay @janeDoe have a look at this, also @domenic',
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    public function it_can_fetch_all_the_mentioned_users_starting_with_the_given_character()
    {
        $john = create('User', ['name' => 'johnDoe']);

        $jane = create('User', ['name' => 'janeDoe']);

        $john = create('User', ['name' => 'johnDoe2']);

        $results = $this->json('get', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
