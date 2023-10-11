<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Tests\Fixtures\UserFixtures;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'id' => Str::uuid(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'birthday' => fake()->date(),
            'cpf' => fake()->unique()->numerify('###########'),
            'genre' => 'Masculino',
        ];
    }

    public function user()
    {
        return $this->state([
            'id' => UserFixtures::MATHEUS_ID,
            'first_name' => UserFixtures::MATHEUS_FIRST_NAME,
            'last_name' => UserFixtures::MATHEUS_LAST_NAME,
            'email' => UserFixtures::MATHEUS_EMAIL,
            'birthday' => UserFixtures::MATHEUS_BIRTHDAY,
            'cpf' => UserFixtures::MATHEUS_CPF,
            'genre' => UserFixtures::MATHEUS_GENRE,
        ]);
    }
}
