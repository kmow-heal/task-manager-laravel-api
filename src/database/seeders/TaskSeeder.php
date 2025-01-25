<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(2)->create([
            'user_id' => 1
        ]);

        $users = User::all()->shuffle();
        foreach($users as $user){
            Task::factory()->count(rand(5, 10))
            ->create([
                'user_id' => $user->id
            ]);
        }
    }
}
