<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ad;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'operator' => $this->faker->randomElement(['mci', 'irancell', 'rightel']),
            'price' => $this->faker->numberBetween(10000, 500000),
            'views' => $this->faker->numberBetween(0, 1000),
            'location' => $this->faker->city(),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'image_url' => $this->faker->imageUrl(640, 480, 'business'),
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
        ];
    }

    public function featured()
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function expired()
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
