<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Kudastech Admin',
            'email' => 'kudastech@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Kudastech User',
            'email' => 'success4real2001@gmail.com',
            'password' => Hash::make('password'),
            // 'is_admin' => true
        ]);


        User::factory(10)->create();

        for($i = 0; $i < 5; $i++ ){
            $group = Group::factory()->create([
                // 'owner_id' => 1,
                'owner_id' => User::where('is_admin', true)->first()->id,
            ]);

            $users = User::inRandomOrder()->limit(rand(2, 5))->pluck('id');
            $group->users()->attach(array_unique([1, ...$users]));
        }

        Message::factory(1000)->create();

        $messages = Message::whereNull('group_id')->orderBy('created_at')->get();

        $conversations = $messages->groupBy(function ($messages) {
            return collect([$messages->sender_id, $messages->reciever_id])
                ->sort()->implode('_');
        })->map(function ($groupMessages) {
            return [
                'user_id1' => $groupMessages->first()->sender_id,
                'user_id2' => $groupMessages->first()->reciever_id,
                'last_message_id' => $groupMessages->last()->id,
                'created_at' => new Carbon(),
                'updated_at' => new Carbon(),

            ];
        })->values();

        Conversation::insertOrIgnore($conversations->toArray());
    }
}
