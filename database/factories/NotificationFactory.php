<?php

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return [
        'id'   => Uuid::uuid4()->toString() ,
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: create('User')->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar'],
    ];
});
