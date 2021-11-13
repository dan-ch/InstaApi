<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{

    public function definition()
    {
        return [
            'description' => $this->faker->text(150),
            'img_url' => $this->faker->url(),
            'min_img_url' => $this->faker->url(),
            'tags' => $this->faker->words($this->faker->numberBetween(2, 10), true),
            'author_id' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime()
        ];
    }
}
