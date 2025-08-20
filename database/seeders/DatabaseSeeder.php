<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables to avoid duplication on rerun (optional)
        DB::table('chat_messages')->truncate();
        DB::table('users')->truncate();

        // Create 5 users
        $users = [];

        for ($i = 1; $i <= 5; $i++) {
            $users[$i] = User::create([
                'name' => "User $i",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        // Create 2 chat messages between each user pair
        foreach ($users as $senderId => $sender) {
            foreach ($users as $receiverId => $receiver) {
                if ($senderId !== $receiverId) {
                    DB::table('chat_messages')->insert([
                        [
                            'sender_id' => $sender->id,
                            'receiver_id' => $receiver->id,
                            'message' => "Hello from User $senderId to User $receiverId",
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'sender_id' => $receiver->id,
                            'receiver_id' => $sender->id,
                            'message' => "Reply from User $receiverId to User $senderId",
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                    ]);
                }
            }
        }
    }
}
