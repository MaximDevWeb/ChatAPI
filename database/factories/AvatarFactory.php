<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Avatar>
 */
class AvatarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $num = rand(1, 14);

        return [
            'type' => 1,
            'path' => "/avatars/default/avatar_$num.svg",
            'link' => "https://chat_cloud.hb.bizmrg.com/avatars/default/avatar_$num.svg",
        ];
    }
}
