<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{

    public function definition()
    {
        return [
            'content' => $this->faker->text(150),
            'post_id' => $this->faker->numberBetween(1,100),
            'author_id' => $this->faker->numberBetween(1,10),
            'related_comment_id' => $this->faker->numberBetween(1,300)
        ];
    }
}
