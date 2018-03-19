<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_recives_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->assertCount(0, auth()->user()->notifications);

        $thread = create('Thread')->subscribe();

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'The reply',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('User')->id,
            'body'    => 'The reply',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        factory(DatabaseNotification::class)->create();

        $this->assertCount(
            1,
            $this->getJson("profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }

    /** @test */
    public function a_user_can_clear_a_notification()
    {
        factory(DatabaseNotification::class)->create();

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $this->delete("profiles/" . $user->name . "/notifications/" . $user->unreadNotifications->first()->id);

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
