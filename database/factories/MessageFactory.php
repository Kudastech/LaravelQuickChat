<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $senderId = $this->faker->randomElement([0, 1]);
        if ($senderId === 0) {
            $senderId = $this->faker->randomElement(User::where('id', '!=', 1)->pluck('id')->toArray());
            $recieverId = 1;
        } else {
            $recieverId = $this->faker->randomElement(User::pluck('id')->toArray());

        }

        $groupId = null;

        if ($this->faker->boolean(50)) {
            $groupId = $this->faker->randomElement(Group::pluck('id')->toArray());

            $group = Group::find($groupId);
            $senderId = $this->faker->randomElement($group->users->pluck('id')->toArray());

            $recieverId = null;
        }

        // $recieverId = $this->faker->randomElement([0, 1]);
        // $groupId = $this->faker->randomElement([0, 1]);
        return [
            'sender_id' => $senderId,
            'reciever_id' => $recieverId,
            'group_id' => $groupId,
            'message' => $this->faker->realText(200),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')

        ];
    }
}