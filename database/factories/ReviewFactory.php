<?php

namespace Database\Factories;

use App\Models\Bookable;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'content' => $this->faker->sentence(5,true),
            'rating' => rand(1,5),
            'bookable_id'=> Bookable::all()->random()->id,
        ];
    }
}
