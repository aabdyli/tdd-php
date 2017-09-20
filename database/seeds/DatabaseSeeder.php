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
        factory('App\User', [
            'name' => 'John Doe',
            'email' => 'john@mail.com',
        ])->create();
        factory('App\User', 10)->create();
        factory('App\Channel', 5)->create();
        for ($i=0; $i < 50; $i++) {
            factory('App\Thread')->create([
                'user_id' => rand(1, 11),
                'channel_id' => rand(1, 5),
            ]);
        }
        for ($i=0; $i < 200; $i++) {
            factory('App\Reply')->create([
                'thread_id' => rand(1, 50),
                'user_id' => rand(1, 11),
            ]);
        }
        // $this->call(UsersTableSeeder::class);
    }
}
