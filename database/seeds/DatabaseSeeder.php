<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')->create([
            'name' => 'johnDoe',
            'email' => 'john@mail.com',
        ]);

        factory('App\User')->create([
            'name' => 'janeDoe',
            'email' => 'jane@mail.com',
        ]);
        factory('App\User', 10)->create();
        factory('App\Channel', 5)->create();
        for ($i=0; $i < 50; $i++) {
            $user = rand(1, 11);
            \Auth::loginUsingId($user);
            factory('App\Thread')->create([
                'user_id' => $user,
                'channel_id' => rand(1, 5),
            ]);
        }
        for ($i=0; $i < 200; $i++) {
            $user = rand(1, 11);
            \Auth::loginUsingId($user);
            factory('App\Reply')->create([
                'thread_id' => rand(1, 50),
                'user_id' => $user,
            ]);
        }
        // $this->call(UsersTableSeeder::class);
    }
}
