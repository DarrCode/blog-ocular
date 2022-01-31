<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'slug' => $this->faker->sentence,
            'author' => $this->faker->firstNameMale,
            'visits' => $this->faker->numberBetween($min = 10, $max = 100),
            'description' => $this->faker->text($maxNbChars = 200),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'published' => $this->faker->randomElement([true, false])
        ];
    }
}
