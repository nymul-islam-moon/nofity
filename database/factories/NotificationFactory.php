<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Fetch a random set of tag IDs from the Tag model
        $tags = Tag::inRandomOrder()->take(5)->pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'short_description' => $this->faker->text(100),
            'tags' => json_encode($tags), // Encode the tag IDs as a JSON array
            'status' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
