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
        create('User', [
            'name' => 'John Doe',
            'email' => 'john@mail.com'
        ]);
        create('User', [], 10);
        create('Channel', [], 5);
        for ($i=0; $i < 50; $i++) {
            create('Thread', [
                'user_id' => rand(1, 11),
                'channel_id' => rand(1, 5)
            ]);
        }
        for ($i=0; $i < 200; $i++) {
            create('Reply', [
                'thread_id' => rand(1, 50),
                'user_id' => rand(1, 11)
            ]);
        }
        // $this->call(UsersTableSeeder::class);
    }
}
