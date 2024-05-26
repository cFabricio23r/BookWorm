<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Summary>
 */
class SummaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'year' => $this->faker->year,
            'summary' => $this->faker->paragraph,
            'key_aspects' => [
                [
                    'aspect' => $this->faker->sentence,
                    'page' => $this->faker->numberBetween(1, 100),
                    'description' => $this->faker->paragraph,
                ],
            ],
            'context' => [
                [
                    'role' => 'user',
                    'content' => $this->faker->paragraph,
                ],
            ],
        ];
    }

    public function withUser(?User $user = null): self
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user ?? UserFactory::new(),
        ]);
    }
}
