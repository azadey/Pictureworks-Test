<?php

namespace Database\Factories;

use Api\Modules\UserComment\Models\UserComment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name,
            'comments' => $this->faker->text

        ];
    }
}
