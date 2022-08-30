<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Avatar;
use App\Models\Profile;
use App\Models\Search;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3000)
             ->has(Profile::factory())
             ->has(Avatar::factory())
             ->has(Search::factory()
                ->state(
                    function (array $attributes, User $user) {
                        return [
                            'login' => $user->login,
                            'full_name' => $user->profile->first_name.' '.$user->profile->last_name,
                        ];
                    }
                )
             )
             ->create();
    }
}
