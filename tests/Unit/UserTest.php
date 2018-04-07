<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('User');

        $reply = create('Reply', ['user_id' => $user->id]);
        
        $this->assertEquals($user->lastReply->id, $reply->id);
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = create('User');

        $this->assertEquals('http://localhost/avatars/default.jpg', $user->avatar());

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals('http://localhost/avatars/me.jpg', $user->avatar());
    }
}
