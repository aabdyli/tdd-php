<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
